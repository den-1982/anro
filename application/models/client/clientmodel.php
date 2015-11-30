<?php
class clientModel extends CI_Model
{
	public function callBack()
	{
		$error = array();
		$response = array(
			'result' => '',
			'error' => array()
		);
		
		$data['name']		= isset($_POST['name'])		? clean($_POST['name'], true, true)		: '';
		$data['email']		= isset($_POST['email'])	? clean($_POST['email'], true, true)	: '';
		$data['message']	= isset($_POST['message'])	? clean($_POST['message'], true, true)	: '';

		if ( ! $data['name']) $error['name'] = $this->lang->line('form_error');
		if ( ! $data['email']) $error['email'] = $this->lang->line('form_error');
		if ( ! $data['message']) $error['message'] = $this->lang->line('form_error');
		
		$response['error'] = $error;
		if ( $error ) return $response;
		
		$msg = '
		<html>
			<head>
			  <title>Сообщение '.strtoupper(SERVER).'</title>
			</head>
			<body>
				<h2 style="text-align:center;color:#fff;background:#c7282a;margin:0;">'.strtoupper(SERVER).'</h2>
				<table width="100%" cellpadding="4" cellspacing="0" style="border-collapse:collapse;">
					<tr>
						<td width="150px" align="right" style="border:1px solid #ccc">
							<small>Имя</small>
						</td>
						<td valign="top" align="left" style="border:1px solid #ccc">'.$data['name'].'</td>
					</tr>
					<tr>
						<td width="150px" align="right" style="border:1px solid #ccc">
							<small>e-mail</small>
						</td>
						<td valign="top" align="left" style="border:1px solid #ccc">'.$data['email'].'</td>
					</tr>
					<tr>
						<td align="right" style="border:1px solid #ccc">
							<small>Сообщение</small>
						</td>
						<td valign="top" align="left" style="border:1px solid #ccc">'.$data['message'].'</td>
					</tr>
				</table>
			</body>
		</html>';
		
		$to			= isset($this->data['settings']->email) ? $this->data['settings']->email : '';
		$tema		= 'Сообщение - сайт';	
		$headers	= "From: ".strtoupper(SERVER)." <webmaster@".strtolower(SERVER).">\r\n";
		$headers	.= "Content-type: text/html; charset=\"utf-8\"";
		$res = mail($to, $tema, $msg, $headers);
		
		$html = 
		'<div class="response-callback">
			<h3><i>'.$this->lang->line('callback_done').'</i></h3>
		</div>';
		
		$response = array(
			'result' => $html,
			'error' => $error
		);

		return $response;
	}
}

?>