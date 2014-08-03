<?php
use RuDev\View;
use RuDev\Api;
use RuDev\Method;

/**
 * Class HomeController
 */
class HomeController extends BaseController
{
    /**
     * @return Api
     */
    protected function getClient()
    {
        return (new Api(
            Config::get('rudev.id'),
            Config::get('rudev.secret')
        ));
    }

    /**
     * @return array
     */
    public function index()
    {
        if (Auth::guest()) {
            return View::make('page.auth', [
                'authLink' => $this->getClient()->getAuthLink([], URL::route('auth'))
            ]);
        }

        return View::make('page.home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function auth()
    {
        if (!Input::get('code')) {
            return Redirect::route('home');
        }
        $client     = $this->getClient();
        $client->requestAccessToken(Input::get('code'));
        $response   = $client->request(Method::CURRENT_USER);

        if ($response['status'] == 'success') {
            User::createFromResponse((object)$response['data']);
        }
        return Redirect::route('home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        if (!Auth::guest()) {
            Auth::logout();
        }
        return Redirect::route('home');
    }
}
