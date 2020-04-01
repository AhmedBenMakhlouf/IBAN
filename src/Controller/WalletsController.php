<?php


namespace App\Controller;


use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class WalletsController extends  AbstractController
{
    /**
     * @Route("/walletslist", name="get_wallets_list", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="returned with success",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="bad request parameters",
     * )
     * @SWG\Parameter( name="page", in="query", required=false, type="integer", description="insert the page"),
     * @SWG\Parameter( name="perpage", in="query", required=false, type="integer", description="insert per page"),
     * @SWG\Parameter( name="sort", in="query", required=false, type="string", description="insert the order"),
     * @Security(name="Bearer")
     * @param Request $request
     * @return JsonResponse
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function GetWalletsList(Request $request)
    {
        $page = $request->get('page');
        $perPage = $request->get('perPage');
        $sort = $request->get('sort');

        if (!$page){$page=1;}
        if (!$perPage){$perPage=10;}
        if (!$sort){$sort='ASC';}

        $client = HttpClient::create(['headers' => [
            'Login' => 'a00720d',
            'Pass' =>   '6KPPczga4H6pR+ZeMj+iQ5UpB0foUoO3hQWOjUiYkESU3HGLfXwce8He7TfwY/k4c3hAcFViIFfKUC+GwcbYsQ=='],
            'query' => [
                'page' => $page,
                'per_page' => $perPage,
                'sort' => $sort
        ]]);


            $response = $client->request('GET', 'https://sandbox2.ibanfirst.com/api -');
            if (!$response){
                return new JsonResponse('error',400);
            }


        if (200 !== $response->getStatusCode()) {
            return new JsonResponse($response->toArray(),$response->getStatusCode());
        }

        return new JsonResponse($response->toArray(),$response->getStatusCode());
    }

    /**
     * @Route("/wallets/{id}", name="get_wallets_list_by_id", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="returned with success",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="bad request parameters",
     * )
     * @Security(name="Bearer")
     * @param $id
     * @return JsonResponse
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getWalletsListDetails($id)
    {
        $client = HttpClient::create(['headers' => [
            'Login' => 'a00720d',
            'Pass' =>   '6KPPczga4H6pR+ZeMj+iQ5UpB0foUoO3hQWOjUiYkESU3HGLfXwce8He7TfwY/k4c3hAcFViIFfKUC+GwcbYsQ==']]);

        $url= 'https://sandbox2.ibanfirst.com/api -/'.$id;
        $response = $client->request('GET',$url);
        if (!$response){
            return new JsonResponse('error',400);
        }


        if (200 !== $response->getStatusCode()) {
            return new JsonResponse($response->toArray(),$response->getStatusCode());
        }

        return new JsonResponse($response->toArray(),$response->getStatusCode());
    }

    /**
     * @Route("/wallets/{id}/balance/{date}", name="get_wallets_list_by_idate", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="returned with success",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="bad request parameters",
     * )
     * @Security(name="Bearer")
     * @param $id
     * @param $date
     * @return JsonResponse
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getWalletsByGivenDate($id,$date)
    {
        $client = HttpClient::create(['headers' => [
            'Login' => 'a00720d',
            'Pass' =>   '6KPPczga4H6pR+ZeMj+iQ5UpB0foUoO3hQWOjUiYkESU3HGLfXwce8He7TfwY/k4c3hAcFViIFfKUC+GwcbYsQ==']]);

        $url= 'https://sandbox2.ibanfirst.com/api -/'.$id.'balance/'.$date;
        $response = $client->request('GET',$url);
        if (!$response){
            return new JsonResponse('error',400);
        }


        if (200 !== $response->getStatusCode()) {
            return new JsonResponse($response->toArray(),$response->getStatusCode());
        }

        return new JsonResponse($response->toArray(),$response->getStatusCode());
    }


    /**
     * @Route("/newWallets", name="submit_wallets", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="returned with success",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="bad request parameters",
     * )
     * @SWG\Parameter( name="wallets", in="body", description="new wallets", required=true, format="application/json",
     * @SWG\Schema( type="object",
     * @SWG\Property(property="currency", type="string", example="USD"),
     * @SWG\Property(property="tag", type="string", example="tags"),
     * @SWG\Property( property="holder", type="array",
     * @SWG\Items( type="object",
     * @SWG\Property(property="name", type="string" ),
     * @SWG\Property(property="type", type="string"),
     * @SWG\Property(property="adress", type="array",
     *     @SWG\Items( type="object",
     *          @SWG\Property(property="street", type="string"),
     *          @SWG\Property(property="postalCode", type="string"),
     *          @SWG\Property(property="city", type="string"),
     *          @SWG\Property(property="provence", type="string"),
     *          @SWG\Property(property="country", type="string")
     *     )),
     *      )
     *     ),
     *  )
     * ),
     * @Security(name="Bearer")
     * @param Request $request
     * @return JsonResponse
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function submitWallets(Request $request)
    {
        $client = HttpClient::create(['headers' => [
            'Login' => 'a00720d',
            'Pass' =>   '6KPPczga4H6pR+ZeMj+iQ5UpB0foUoO3hQWOjUiYkESU3HGLfXwce8He7TfwY/k4c3hAcFViIFfKUC+GwcbYsQ==']]);

        $url= 'https://sandbox2.ibanfirst.com/api -/';
        $response = $client->request('POST',$url, [ 'body' =>
            ['currency'=> $request->get('currency'),
             'tag' => $request->get('tag'),
                'holder' => $request->get('holder')
                ]
        ]);
        if (!$response){
            return new JsonResponse('error',400);
        }


        if (200 !== $response->getStatusCode()) {
            return new JsonResponse($response->toArray(),$response->getStatusCode());
        }

        return new JsonResponse($response->toArray(),$response->getStatusCode());
    }
}