<?php

namespace LaraCar\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaraCar\Http\Controllers\Controller;
use Carbon\Carbon;

class FilterController extends Controller
{

    public function search(Request $request)
    {

        $loja = filter_var(str_replace(
            env('APP_URL') . '/ong/',
            '',
            $request->server('HTTP_REFERER')
        ), FILTER_SANITIZE_STRIPPED);
        $company = DB::table('companies')->where('slug', $loja)->first();

        if ($company) {
            $user = ($company->user);
        } else {
            $user = null;
        }

        session()->remove('user');
        session()->remove('city');
        session()->remove('category');

        if ($request->search === 'buy') {
            session()->put('user', $user);
            session()->put('sale', true);
            session()->remove('rent');
            $cityAutomotives = $this->createQuery('city');
        }

        if ($request->search === 'rent') {
            session()->put('user', $user);
            session()->put('rent', true);
            session()->remove('sale');
            $cityAutomotives = $this->createQuery('city');
        }

        if ($cityAutomotives->count()) {
            foreach ($cityAutomotives as $automotive) {
                $city[] = $automotive->city;
            }

            $collect = collect($city);
            return response()->json($this->setResponse('success', $collect->unique()->toArray()));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function city(Request $request)
    {
        session()->remove('category');

        session()->put('city', $request->search);
        $categoryAutomotives = $this->createQuery('category');

        if ($categoryAutomotives->count()) {
            foreach ($categoryAutomotives as $automotive) {
                $category[] = $automotive->category;
            }

            $category[] = 'Indiferente';

            $collect = collect($category)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function category(Request $request)
    {
        session()->put('category', $request->search);

        return response()->json($this->setResponse('success', []));
    }

    private function setResponse(string $status, array $data = null, string $message = null)
    {
        return [
            'status' => $status,
            'data' => $data,
            'message' => $message
        ];
    }

    public function clearAllData()
    {
        session()->remove('user');
        session()->remove('sale');
        session()->remove('rent');
        session()->remove('city');
        session()->remove('category');
    }

    public function createQuery($field)
    {

        $user = session('user');
        $sale = session('sale');
        $rent = session('rent');
        $city = session('city');
        $category = session('category');

        $query = DB::table('automotives')
            ->where('status', '=', '1')->where('sale', '1')->whereDate('active_date', '>=', Carbon::now()->subDays(30))
            ->when($user, function ($query, $user) {
                return $query->where('user', '=', $user);
            })
            ->when($sale, function ($query, $sale) {
                return $query->where('sale', $sale);
            })
            ->when($rent, function ($query, $rent) {
                return $query->where('rent', $rent);
            })
            ->when($city, function ($query, $city) {
                return $query->where('city', $city);
            })
            ->when($category, function ($query, $category) {

                if ($category == 'Indiferente') {
                    return $query;
                }
                return $query->where('category', $category);
            })
            ->get(explode(',', $field));

        return $query;
    }
}
