
<?php

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

//FECHA ACTUAL
$fecha = date("d-m-Y");

//ARCHIVOS REQUERIDOS PARA LAS CONFIGURACIONES
require_once('../../../../config/Config.php');
require_once('../../../../config/Accesos.php');

//INICIAR SESSION PARA SABER EL ID DELCLIENTE ACTUAL
Accesos::iniciar();

//CONEXION
$conexion = new PDO('mysql:host=' . DB_HOST .';dbname=' . DB_NAME, DB_USER, DB_PASS, array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '. DB_CHAR));

//ID DEL CLIENTE ACTUAL
$idCliente = Accesos::getDatos('cliente')['cliente_id'];

$facturaFinal = $conexion->prepare("SELECT s.*,c.*,p.*
FROM sucursal AS s INNER JOIN cliente AS c ON s.sucursal_ID = c.fk_sucursal_cliente
     INNER JOIN proformatemporal AS p ON c.cliente_id = p.cliente_cliente_id
WHERE c.cliente_id = :id ORDER BY p.proforma_id DESC LIMIT 1");

//IRFORMACION QUE SE TRAE DESDE LA BASE DE DATOS
$facturaFinal->execute(['id' => $idCliente]);
$datos = $facturaFinal->fetch();

// INFORMACION QUE BIENE DESDE EL SITI WEB
$coleccion = json_decode($datos['proforma_productos']);
$comprobar = [];
$controNoencotro = false;


for($i = 0; $i < count($coleccion); $i++){ //RECORREMOS LA LISTA DE PRODUCTOS
	$total = 0;

	for($j = 0; $j < count($coleccion); $j++){ //REALIZAMOS UN CONTEO INDIVIDUAL
		if($coleccion[$i] == $coleccion[$j]){
			$total += 1;
		}
	}	

	if($total == 1){//VERIFICAMOS QUE SOLO SE ENCONTRO UN ELEMENTO SIN REPETICIONES
		array_push($comprobar,array("id" =>  $coleccion[$id]->product_ID, "total" => $total,"product" => $coleccion[$i]));
	}

	if($total >= 2){//SI HAY MAS DE DOS ELEMENTOS
		if(!$comprobar){//AGREGAR EL PRIMER ELEMENTOS A LA LISTA VACIA
			array_push($comprobar,array("id" =>  $coleccion[$i]->product_ID, "total" => $total,"product" => $coleccion[$i]));
		}else{//EN CASO DE QUE LALISTA TENGA UN REGISTRO 
			for($k = 0; $k <count($comprobar); $k++){//COMPROBAR QUE EL ELEMENTO A AGREGAR NO EXISTA EL LA LISTA
				$controNoencotro = false;//SI NO EXISTE 

				if($coleccion[$i]->product_ID == $comprobar[$k]['id']){//SI EXISTE
					$controNoencotro = true;
					break;
				}
			}

			if(!$controNoencotro){//EN CASO DE NO EXISTIR LO AGREGAMOS DE LO CONTRARIO NO LO AGREGAMOS
				array_push($comprobar,array("id" =>  $coleccion[$i]->product_ID, "total" => $total,"product" => $coleccion[$i]));
			};

		}
	}
}

// $nuevo = json_encode($coleccion);
// echo"<script>
// 	let reg = ".$nuevo.";
// 	const itemsFinal = [];

// 	let nuevoElem = [];
// 	reg.forEach(e => nuevoElem.push(e.product_ID));
// 	nuevoElem = new Set(nuevoElem);
// 	let final = [];
	
// 	for (const item of nuevoElem) {
// 		final.push(item);
// 	}

// 	final.forEach(e => {
// 		let cont = 0;

// 		reg.forEach(item => {
// 			if(e === item.product_ID) cont+=1;
			
// 		})

// 		for(let i = 0; i < reg.length - 1; i++){
// 			if(e  === reg[i].product_ID){
// 				itemsFinal.push({total: cont, Product: reg[i]})
// 				break;
// 			}
// 		}
// 	})

// 	console.log(itemsFinal)
// </script>";

//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------
$html ='
	<table style="margin-top:30px">
		<tr>
			<td style="width:220"><img src="images/logo.png" style="width:70px"><span style="font-size:15px;font-weight:bold">'.$datos['sucursal_nombre'].'</span></td>

			<td style="background-color:white">
				<div style="font-size:8.5px; text-align:right; line-height:15px">
					
					<br>
					' . $datos['sucursal_nombre'] .'
					<br>

					Dirección: '.$datos['sucursal_direccion'].'
				</div>
			</td>

			<td style="background-color:white; width:140px;">
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					<br>
					Teléfono: '.$datos['sucursal_telefono'].'
					
					<br>
					Correo: '.$datos['sucursal_correo'].'
				</div>
			</td>
		</tr>
	</table>

	<table> 
		<tr>
			<td style="width:540px"><img src="images/back.jpg"></td>
		</tr>
	</table>

	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:270px">
				Cliente: '.$datos['cliente_nombres'].' '. $datos['cliente_apellidos'] .'
			</td>

			<td style="border: 1px solid #666; background-color:white; width:120px">
				Direccion: '.$datos['cliente_direccion'].'
			</td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:left">
			
				Fecha:'. $fecha . '
			</td>
		</tr>

		<tr>
			<td style="border: 1px solid #666; background-color:white; width:200px">Identificacion: '.$datos['cliente_cedula'].'</td>
			<td style="border: 1px solid #666; background-color:white; width:130px">Telefono: '.$datos['cliente_telefono'].' </td>
			<td style="border: 1px solid #666; background-color:white; width:210px">Correo: '.$datos['cliente_correo'].' </td>
		</tr>

		<tr>
			<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
		</tr>
	</table>

	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:170px; text-align:center">Producto</td>
			<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Cantidad</td>
			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Unidad de Medida</td>
			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Unit.</td>
			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Total</td>
		</tr>
	</table>';
//---------------------------------------------------------



$html .= '<table style="font-size:10px; padding:5px 10px;">';

$totalGeneral = 0.0;

foreach($comprobar AS $c2){

	$totalGeneral += $c2['total'] * $c2['product']->product_precio;

	$html.='<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:170px; text-align:center">
				'.$c2['product']->product_nombre.'
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				'.$c2['total']. '
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				'. $c2['product']->uni .'
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				'.$c2['product']->product_precio.'
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				'.$c2['total'] * $c2['product']->product_precio.'
			</td>
		</tr>';
	}

$html.='</table>';


// ---------------------------------------------------------
	$html .='
		<table style="font-size:10px; padding:5px 10px;">

			<tr>

				<td style="color:#333; background-color:white; width:340px; text-align:center">

				</td>

				<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

				<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>

			</tr>
			
			<tr>
			
				<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

				<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
					Neto:
				</td>

				<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
					C$ '.$totalGeneral.'
				</td>

			</tr>


			<tr>
			
				<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

				<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
					Total: 
				</td>
				
				<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
					C$ '.$totalGeneral.'
				</td>

			</tr>
	</table>';

$pdf->writeHTML($html, true, false, false, false, '');



// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

//$pdf->Output('factura.pdf', 'D');
ob_end_clean();
$pdf->Output('Proforma.pdf');

