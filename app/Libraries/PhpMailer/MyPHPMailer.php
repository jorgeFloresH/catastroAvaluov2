<?php
namespace App\Libraries\PhpMailer;
//require("class.phpmailer.php");
//require_once 'vendor/LibInboro/phpmailer/class.phpmailer.php';
class MyPHPMailer extends PhpMailer {
	
	
	function __construct(){
	    parent::__construct(false);
	    $this->Mailer = "mail";
	    $this->Host = "mail.catastrocbba.com";
	    $this->SMTPAuth = true;
	    $this->Port = 25;
	    $this->Username = "Informacion catastro Cochabamba";
	    $this->Password = "CatastroCBBA.Info2016";
	    $this->From = "info@catastrocbba.com";
	    $this->FromName = "Catastro Cochabamba";
	    $this->WordWrap = 50;
	    $this->copia = "cesar_rocha@inboro.com";
	}
	
	function error_handler($msg) {
	    
		print("Error de envio de correo del sistema");
		print("Descripcion:");
		printf("%s", $msg);
		exit;
	}
	
	
	public function enviarMailNotificacion( $mailDestino, $subject, $tituloContenido,$contenido,$nombreUsuarioDestino) {
	    $headers = 'MIME-Version: 1.0' . "\r\n";
	    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	    $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- If you delete this meta tag, Half Life 3 will never be released. -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ZURBemails</title>
	
<link rel="stylesheet" type="text/css" href="http://catastrocbba.com/catastroBackend/public/mail/stylesheets/email.css" />

</head>
 
<body bgcolor="#FFFFFF">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#999999">
	<tr>
		<td></td>
		<td class="header container" >
				
				<div class="content">
				<table bgcolor="#999999">
					<tr>
						<td><img src="http://www.catastrocbba.com/catastroBackend/public/assets/css/escudoCbba.png" width=""60/></td>
						<td align="right"><h6 class="collapse">Catastro Cochabamba</h6></td>
					</tr>
				</table>
				</div>
				
		</td>
		<td></td>
	</tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap">
	<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF">

			<div class="content">
			<table>
				<tr>
					<td>
						<h3>Hola, '.$nombreUsuarioDestino.'</h3>
						<p class="lead">'.$tituloContenido.'</p>
						<p>'.$contenido.'</p>
										
												
						<!-- social & contact -->
						<table class="social" width="100%">
							<tr>
								<td>
									
									<!-- column 1 -->
									<table align="left" class="column">
										
									</table><!-- /column 1 -->	
									
									<!-- column 2 -->
									<table align="left" class="column">
										<tr>
											<td>				
																			
												<h5 class="">Informaci&oacute;n de Contacto:</h5>												
												<p>
													CENTRAL TELEFONICA: <strong>4258030</strong><br/>
													ADMINISTRATIVA <strong>4250057</strong><br/>
													FINANCIERA <strong>4256768</strong><br/>
													SERVICIOS TECNICOS <strong>4255026</strong><br/>
													DESARROLLO HUMANO <strong>4520622</strong><br/>
													DESARROLLO INSTITUCIONAL Y ECONOMICO <strong>4510135</strong><br/>
													OFICIALIA SUPERIOR DE CULTURA <strong>4252090</strong><br/>
												
                
											</td>
										</tr>
									</table><!-- /column 2 -->
									
									<span class="clear"></span>	
									
								</td>
							</tr>
						</table><!-- /social & contact -->
						
					</td>
				</tr>
			</table>
			</div><!-- /content -->
									
		</td>
		<td></td>
	</tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<!-- <table class="footer-wrap">
	<tr>
		<td></td>
		<td class="container">
			
				>
				<div class="content">
				<table>
				<tr>
					<td align="center">
						<p>
							<a href="#">Terms</a> |
							<a href="#">Privacy</a> |
							<a href="#"><unsubscribe>Unsubscribe</unsubscribe></a>
						</p>
					</td>
				</tr>
			</table>
				</div>
				
		</td>
		<td></td>
	</tr>
</table>-->
<!-- /FOOTER -->

</body>
</html>';
	    $data=array();
	     
	     
	    
	     
	     
	    //$mail = new \MyPHPMailer();
	    $this->AddAddress($mailDestino,"$nombreUsuarioDestino");
	    //$this->AddCC($mail->copia,$mail->FromName);
	    //$this->Subject = "".$subject;
	    $this->Subject = "".$subject;
	    
	    $this->IsHTML(TRUE);
	    //return $this->Host;
	    try{
	        $this->Body = $message;
	        if($this->Send())
	            return TRUE;
	        else return FALSE;
	    }catch(\Exception $e){
	        return $e->__toString();
	        return FALSE;
	    }
	    //return FALSE; 
	   
	}
	
}


?>