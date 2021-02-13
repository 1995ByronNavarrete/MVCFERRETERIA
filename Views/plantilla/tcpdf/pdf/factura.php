
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
     INNER JOIN proforma AS p ON c.cliente_id = p.fk_cliente
WHERE c.cliente_id = :id ORDER BY p.proforma_id DESC LIMIT 1");

$facturaFinal->execute(['id' => $idCliente]);
$datos = $facturaFinal->fetch();
$coleccion = json_decode($datos['proforma_productos']);
$coleccion2 = [];
$coleccion3 = $coleccion;
$coleccion4 = $coleccion;
$idMayor = '';



foreach($coleccion AS $c){

	$total = 0;
	$idTemp = "";
	$idTempOne = "";

	if($idMayor == $c->product_ID){continue; $idMayor = "";}
	else{
	
		foreach($coleccion3 AS $c3){
			if($c->product_ID == $c3->product_ID){
				$total += 1;

				if($total == 1) $idTempOne = $c->product_ID;
				else if($total >= 2){
					$idTemp = $c->product_ID;
					$idMayor = $c->product_ID;
				}

			}else{
				$total;
			}
		}

		
		foreach($coleccion4 AS $c4){
			if($c4->product_ID == $idTempOne){
				array_push($coleccion2, array("total" => $total, "product" => $c4));
				break;
			}else if($c4->product_ID == $idTemp){
				array_push($coleccion2, array("total" => $total, "product" => $c4));
				break;
			}
		}
	}
}

//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------
$html ='
	<h2 style="width:100%;display:block;color:#ccc; margin-top:10px; font-size: 25px">Proforma</h2>
	<table style="margin-top:30px">
		<tr>
			<td style="width:150px"><img src="images/logo.png"></td>

			<td style="background-color:white;">
				<div style="font-size:8.5px; text-align:right; line-height:15px">
					
					<br>
					' . $datos['sucursal_nombre'] .'
					<br>

					Dirección: '.$datos['sucursal_direccion'].'
				</div>
			</td>

			<td style="background-color:white; width:140px">
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

foreach($coleccion2 AS $c2){

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

?>