<?php

namespace LaraCar\Http\Controllers\Web;

use Illuminate\Http\Request;
use LaraCar\Http\Controllers\Controller;
use LaraCar\Automotive;
use LaraCar\Mail\Web\Contact;
use Illuminate\Support\Facades\Mail;
use LaraCar\Company;
use Illuminate\Support\Facades\Storage;
use LaraCar\Banner;
use LaraCar\Term;

class WebController extends Controller
{

    public function home()
    {
        $head = $this->seo->render(
            env('APP_NAME'),
            'Encontre o amiguinho dos seus sonhos na melhor plataforma web do Rio de Janeiro',
            route('web.home'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        $automotivesForSale = Automotive::sale()->available()->orderBy('created_at', 'desc')->limit(12)->get();
        $automotivesForRent = Automotive::rent()->available()->orderBy('created_at', 'desc')->limit(12)->get();
        $cityAutomotives = Automotive::sale()->available()->get();
        session()->remove('user');
        session()->remove('city');
        session()->remove('brand');
        session()->remove('model');
        session()->remove('year');
        session()->remove('mileage');
        session()->remove('price_base');
        session()->remove('price_limit');
        $banner = Banner::first();
        $cities = [];
        if ($cityAutomotives->count()) {
            foreach ($cityAutomotives as $automotive) {
                $city[] = $automotive->city;
            }
            $cities = collect(array_filter($city))->unique()->sort();
        }

        return view('web.home', [
            'head' => $head,
            'automotivesForSale' => $automotivesForSale,
            'automotivesForRent' => $automotivesForRent,
            'forSale' => $forSale,
            'forRent' => $forRent,
            'cities' => $cities,
            'banner' => $banner
        ]);
    }

    public function companies()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - ONGs',
            'Confira as ONGs na melhor plataforma web do Rio de Janeiro',
            route('web.companies'),
            asset('frontend/assets/images/share.png')
        );
        $companies = Company::orderBy('alias_name')->get();
        return view('web.companies', [
            'head' => $head,
            'companies' => $companies
        ]);
    }

    public function filterCompany(Request $request)
    {
        $company = Company::where('slug', $request->slug)->first();
        if ($company) {
            $head = $this->seo->render(
                env('APP_NAME') . ' - ONG: ' . $company->social_name,
                $company->social_name,
                route('web.filterCompany', ['slug' => $company->slug]),
                $company->cover()
            );

            $automotivesForSale = Automotive::sale()->available()->where('user', $company->user)->orderBy('created_at', 'desc')->get();

            return view('web.company', [
                'head' => $head,
                'company' => $company,
                'automotivesForSale' => $automotivesForSale
            ]);
        } else {
            return redirect()->route('web.companies');
        }
    }

    public function spotlight()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - Destaque',
            'Confira nosso amiguinho de destaque na melhor plataforma web do Rio de Janeiro',
            route('web.spotlight'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        return view('web.spotlight', [
            'head' => $head,
            'forSale' => $forSale,
            'forRent' => $forRent
        ]);
    }

    public function contact()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - Contato',
            'Quer encontrar o amiguinho de quatro patas dos seus sonhos? Entre em contato com a nossa equipe!',
            route('web.contact'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        return view('web.contact', [
            'head' => $head,
            'forSale' => $forSale,
            'forRent' => $forRent
        ]);
    }

    public function buy()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - Compra',
            'Encontro o amiguinho dos seus sonhos na melhor plataforma web do Rio de Janeiro',
            route('web.buy'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        $filter = new FilterController();
        $filter->clearAllData();
        $automotives = Automotive::sale()->available()->sortable(['created_at' => 'desc'])->paginate(20);

        session()->remove('user');
        session()->remove('city');
        session()->remove('brand');
        session()->remove('model');
        session()->remove('year');
        session()->remove('mileage');
        session()->remove('price_base');
        session()->remove('price_limit');

        $cities = [];
        if ($automotives->count()) {
            foreach ($automotives as $automotive) {
                $city[] = $automotive->city;
            }
            $cities = collect(array_filter($city))->unique()->sort();
        }

        $banner = Banner::first();

        return view('web.filter', [
            'head' => $head,
            'forSale' => $forSale,
            'forRent' => $forRent,
            'automotives' => $automotives,
            'type' => 'sale',
            'cities' => $cities,
            'banner' => $banner
        ]);
    }

    public function buyAutomotive(Request $request)
    {
        $automotive = Automotive::where('slug', $request->slug)->first();
        if ($automotive) {
            $automotive->views = $automotive->views + 1;
            $automotive->save();
            $head = $this->seo->render(
                env('APP_NAME') . ' - Compra',
                $automotive->headline ?? $automotive->title,
                route('web.buyAutomotive', ['slug' => $automotive->slug]),
                $automotive->cover()
            );
            $forSale = Automotive::sale()->available()->first();
            $forRent = Automotive::rent()->available()->first();
            $company = Company::where('user', $automotive->ownerObject()->id)->first();
            $banner = Banner::first();
            return view('web.automotive', [
                'head' => $head,
                'forSale' => $forSale,
                'forRent' => $forRent,
                'automotive' => $automotive,
                'type' => 'sale',
                'company' => $company,
                'banner' => $banner
            ]);
        } else {
            return redirect()->route('web.filter');
        }
    }

    public function filter()
    {
        $head = $this->seo->render(
            env('APP_NAME'),
            'Encontre o amiguinho dos seus sonhos na melhor plataforma web do Rio de Janeiro',
            route('web.filter'),
            asset('frontend/assets/images/share.png')
        );
        $filter = new FilterController();
        $itemAutomotives = $filter->createQuery('id');
        foreach ($itemAutomotives as $automotive) {
            $automotives[] = $automotive->id;
        }

        if (!empty($automotives)) {
            $automotives = Automotive::whereIn('id', $automotives)->sale()->available()->orderBy('created_at', 'desc')->get();
        } else {
            $automotives = null;
        }

        $filter->clearAllData();

        $collect = Automotive::sale()->available()->get();
        $cities = [];
        if ($collect->count()) {
            foreach ($collect as $automotive) {
                $city[] = $automotive->city;
            }
            $cities = collect(array_filter($city))->unique()->sort();
        }

        $banner = Banner::first();

        $spotlight = Automotive::sale()->available()->spotlight()->inRandomOrder()->take(24)->get();
        $gear = [];
        $fuel = [];
        $state = [];
        $cityCar = [];
        if (!empty($automotives)) {

            foreach ($automotives as $automotive) {
                $gear[] = $automotive->gear;
                $fuel[] = $automotive->fuel;
                $state[] = $automotive->state;
                $cityCar[] = $automotive->city;
            }
            $gear = collect(array_filter($gear))->unique()->sort();
            $fuel = collect(array_filter($fuel))->unique()->sort();
            $state = collect(array_filter($state))->unique()->sort();
            $cityCar = collect(array_filter($cityCar))->unique()->sort();
        }

        $cityState = [];
        if (count($state) && count($cityCar)) {
            foreach ($collect as $automotive) {
                if ($state->contains($automotive->state) && !$cityCar->contains($automotive->city)) {
                    $cityState[] = $automotive->city;
                }
            }
            $cityState = collect(array_filter($cityState))->unique()->sort();
        }

        return view('web.filter', [
            'head' => $head,
            'automotives' => $automotives,
            'cities' => $cities,
            'banner' => $banner,
            'spotlight' => $spotlight,
            'gear' => $gear,
            'fuel' => $fuel,
            'state' => $state,
            'cityState' => $cityState,
            'collect' => $collect
        ]);
    }

    public function sendEmail(Request $request)
    {
        if (empty($request['email'])) {
            return redirect()->route('web.home');
        }

        if (isset($request->company)) {
            $company = Company::where('id', $request->company)->first();
        } else {
            $company = null;
        }

        $data = [
            'reply_name' => $request->name,
            'reply_email' => $request->email,
            'cell' => $request->cell,
            'message' => $request->message,
            'company' => ($company ? $company->email : '')
        ];

        Mail::send(new Contact($data));
        Storage::append('usuarios.txt', $request['email']);

        return redirect()->route('web.sendEmailSuccess');
    }

    public function sendEmailSuccess()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - E-mail enviado com sucesso!',
            'E-mail enviado com sucesso para a melhor plataforma web do Rio de Janeiro',
            route('web.policy'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        return view('web.contact_success', [
            'head' => $head,
            'forSale' => $forSale,
            'forRent' => $forRent,
        ]);
    }

    public function policy()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - Política de Privacidade',
            'Política de Privacidade da melhor plataforma web do Rio de Janeiro',
            route('web.policy'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        $term = Term::first();
        return view('web.policy', [
            'head' => $head,
            'forSale' => $forSale,
            'forRent' => $forRent,
            'term' => $term,
        ]);
    }
}
