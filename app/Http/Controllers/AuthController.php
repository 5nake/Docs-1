<?php
namespace App\Http\Controllers;


use App\Api\RuDev;
use App\User;
use Auth;
use Exception;
use Illuminate\Http\Request;
use LogicException;
use RuDev\Api;
use RuDev\Method;

class AuthController extends AbstractController
{
    public function verifyCode(Request $request)
    {
        $code = $request->get('code', '');

        $api = RuDev::get()->getApi();

        $errors = [];
        $user = new User();

        $api->requestAccessToken($code);
        try {
            $response = $api->request(Method::CURRENT_USER);
            if (!array_key_exists('status', $response) || $response['status'] !== 'success') {
                throw new LogicException('Invalid response from the authorization server');
            }

            $userData = (object)$response['data'];

            $user = User::where('email', $userData->email)->first();
            if (!$user) {
                $user = new User();
                $user->email = $userData->email;
            }

            $user->login = $userData->login;
            $user->avatar = $userData->avatar;
            $user->password = $userData->uhash;
            $user->save();


            Auth::loginUsingId($user->id);

        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }


        return view('page.auth-window', [
            'errors' => $errors,
            'user'   => $user,
        ]);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
    }
}
