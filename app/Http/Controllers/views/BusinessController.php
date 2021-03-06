<?php

namespace App\Http\Controllers\views;

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\BusinessUser;
use App\ClienteJardepot;
use Illuminate\Support\Facades\Hash;

class BusinessController extends Controller {

    public function registro(Request $request)
    {
        $datos_usuario = [
            'name' => $request->input('userName', ''),
            'email' => $request->input('userEmail', ''),
            'phone' => $request->input('userPhone', ''),
        ];
        $errors = [];
        $user_exists = BusinessUser::where('email', $request->input('userEmail'))->exists();

        if($user_exists){
            array_push($errors, 'El correo electrónico ya se encuentra registrado');
            return view('pages.registro')->with(compact('errors'));
        }
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'jardepot.com';
        $mail->Username = 'business@jardepot.com';
        $mail->Password = 'B3m4sr5#';
        $mail->Port = 587;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
		);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('business@jardepot.com', 'Jardepot Fidelity');

        $user_business = new BusinessUser;
        $user_business->name = $datos_usuario['name'];
        $user_business->active = 1;
        $user_business->created_at = time();
        $user_business->updated_at = time();
        $user_business->password = Hash::make($request->input('password'));
        $user_business->email = $datos_usuario['email'];
        $user_business->phone = $datos_usuario['phone'];
        $user_business->nivel = 'basic';


        if($user_business->save()){
            $ruta = $request->file('rfc')->store('rfcs');
            if($ruta){
                $user_business->ruta_rfc = $ruta;
                $user_business->save();
                $mail->addAddress($user_business->email, $user_business->name);
                // Creamos un nuevo cliente en Jardepot
                $cliente = ClienteJardepot::where('correo', $datos_usuario['email'])->first();
                if(!$cliente){
                    $cliente = new ClienteJardepot;
                    $cliente->nombre = $datos_usuario['name'];
                    $cliente->correo = $datos_usuario['email'];
                    $cliente->fecha = date('Y-m-d');
                    $cliente->telefono = $datos_usuario['phone'];
                }
                $cliente->idBusiness = $user_business->id;
                if(!$cliente->save()){
                    array_push($errors, 'No se ha podido asociar o crear su cliente');
                }
                $contenido = file_get_contents(base_path('/resources/templates/welcome/index.html'));
                $contenido = str_replace('[[nombre_comprador]]', $cliente->nombre, $contenido);
                $mail->AddEmbeddedImage(base_path('/resources/templates/welcome/header.png'), 'header');
                $mail->AddEmbeddedImage(base_path('/resources/templates/welcome/footer.png'), 'footer');
                $mail->Body = $contenido;
                $mail->Subject = '¡Bienvenido a la familia Jardepot!';
                $mail->send();
                return redirect('https://digicom.mx/business/login');
            } else {
                array_push($errors, 'No se ha podido subir el archivo');
            }
        } else {
            array_push($errors, 'No se ha podido crear el usuario');
        }

        if(!empty($errors)){
            return view('pages.registro')->with(compact('errors'));
        }
    }
}
