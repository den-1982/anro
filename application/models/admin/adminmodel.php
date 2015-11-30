<?php
/*
*	ADMIN
*/
class adminModel extends CI_Model
{
	public function getAdmin()
	{
		return $this->db->query('SELECT * FROM admin')->row();
	}
////////////////////////////////////////////////////////////////////// VALID
	public function VALID_ADMIN()
	{
		# LOGOUT
		if ( isset($_GET['logout']) ){
			$this->session->unset_userdata('admin');
			redirect('/admin');
			exit;
		}
		
		# RECOVER PASSWORD
		if ( isset($_POST['recover']) ){
			$this->_recoverPassword();
			redirect('/admin');
			exit;
		}
		
		# AUTH
		if ( isset($_POST['login']) ){
			$login		= isset($_POST['login'])	? mysql_real_escape_string($_POST['login']) : '';
			$password	= isset($_POST['password'])	? mysql_real_escape_string($_POST['password']) : '';

			$admin = $this->db->query('SELECT * FROM admin 
										WHERE login LIKE "'.$login.'" 
											AND password LIKE "'.$password.'" ')->row();
			
			if ($admin){
				$this->session->set_userdata('admin', TRUE);
			}
			
			redirect('/admin');
			exit;
		}
		
		# VALID
		if ( ! $this->session->userdata('admin') ){
			if ($this->uri->total_segments() > 1) redirect('/admin');
			$this->load->view('admin/a_login');
			$this->output->_display();
			exit;
		}
	}
////////////////////////////////////////////////////////////////////// RECOVER
	private function _recoverPassword()
	{
		$response = array(
			'response'=>''
		);
		
		$email = isset($_POST['email']) ? mysql_real_escape_string($_POST['email']) : '';
		
		$admin = $this->db->query('SELECT * FROM admin WHERE email LIKE "'.$email.'"')->row();

		if ($admin){
		
			$msg = '
			<html>
				<head>
					<title>Сообщение сайта '.SERVER.'</title>
				</head>
				<body>
					<h2 style="text-align:center; font-weight:normal;color:#fff;background:#53afea;margin:0;">Восстановление пароля '.SERVER.'</h2>
					<table width="100%" cellpadding="4" cellspacing="0" style="border-collapse:collapse;font-size:14px;">
						<tr style="background:#eee;">
							<td width="150px" align="center" style="border:1px solid #ccc"><small>Login</small></td>
							<td width="150px" align="center" style="border:1px solid #ccc"><small>Password</small></td>
						</tr>
						<tr>
							<td valign="top" align="center" style="border:1px solid #ccc">'.$admin->login.'</td>
							<td valign="top" align="center" style="border:1px solid #ccc">'.$admin->password.'</td>
						</tr>
					</table>';
			
			$to			= $admin->email;
			$tema		= 'Востановление пароля';	
			$headers	= "From: ".strtoupper(SERVER)." <webmaster@".strtoupper(SERVER).">\r\n";
			$headers	.= "Content-type: text/html; charset=\"utf-8\"";
			mail($to, $tema, $msg, $headers);
			
			### скрытие email (ha***@ua.fm)
			$data = explode('@', $to);
			$_a = isset($data[0]) ? $data[0] : '';
			$_b = isset($data[1]) ? $data[1] : '';
			$_r = '';
			
			for ($i=0; $i < strlen($_a); $i++){
				if($i > 1) 
					$_r .= '*';
				else
					$_r .= $_a{$i};
			}
			$email = $_r.'@'.$_b;

			$response['response'] = '<div style="padding:20px 50px;text-align:center;font-size:18px;">На ваш адрес <span style="color:#ff0000;">'.$email.'</span> выслан пароль.</div>';
			echo json_encode($response);
			exit;
		}else{
			$response['response'] = '<div style="padding:20px 50px;text-align:center;font-size:18px;">Такого пользователя ('.$email.') нет!</div>';
			echo json_encode($response);
			exit;
		}
	}
	
}