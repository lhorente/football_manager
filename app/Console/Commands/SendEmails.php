<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Spatie\ArrayToXml\ArrayToXml;

use App\XmlRequest;
use App\Club;
use App\Player;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:xmlRequests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate XML reports and send it by email.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
		$requests = XmlRequest::whereNull('send_at')->limit(5)->get();
		
		$xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		
		$xml .= '<players>'."\n";
		
		$players = Player::get();
		if ($players){
			// for ($i=1;$i<=10000;$i++){
				foreach ($players as $player){
					$xml .= '	<player>'."\n";
					$xml .= '		<name>'.$player->name.'</name>'."\n";
					$xml .= '		<birthdate>'.$player->birthdate.'</birthdate>'."\n";
					$xml .= '		<club>'.$player->club->name.'</club>'."\n";
					$xml .= '	</player>'."\n";
				}
			// }
		}
		
		$xml .= '</players>';
				
		if ($requests){
			foreach ($requests as $request){
				echo 'Sending XML report to '.$request->email."\n";
				
				$file_name = bin2hex(openssl_random_pseudo_bytes(16)).".xml";
				$file_path = public_path()."\\reports\\".$file_name;
				$file_url = url("reports/{$file_name}");
				
				// echo $file_path;exit;
				
				$xmlFile = fopen($file_path, "w");
				fwrite($xmlFile, $xml);
				fclose($xmlFile);

				
				$mail = new PHPMailer(true);
				try {
					// $mail->SMTPDebug = 2;
					$mail->isSMTP();
					$mail->Host       = env("SMTP_HOST");
					$mail->SMTPAuth   = true;
					$mail->Username   = env("SMTP_USER");
					$mail->Password   = env("SMTP_PASS");
					$mail->SMTPSecure = env("SMTP_SECURE");
					$mail->Port       = env("SMTP_PORT");
					$mail->setFrom(env("SMTP_USER"));
					$mail->addAddress($request->email);
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = 'XML Report';
					$mail->Body    = '<a href="'.$file_url.'">Download XML</a>';
					$mail->AltBody = 'Download XML: '.$file_url;
					$mail->send();
					$request->send_at = date("Y-m-d H:i:s");
					$request->save();
					echo 'Sending XML report to '.$request->email.": OK"."\n";
				} catch (Exception $e) {
					echo 'Sending XML report to '.$request->email.": ERROR {$mail->ErrorInfo}"."\n";
				}
			}
		}
    }
}
