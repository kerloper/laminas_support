<?php

namespace Support\Service;

use Content\Service\ItemService;
use Content\Service\MetaService;
use stdClass;
use User\Service\AccountService;
use User\Service\UtilityService;
use function explode;
use function in_array;
use function is_object;
use function json_decode;

class SupportService implements ServiceInterface
{

    /** @var AccountService */
    protected AccountService $accountService;


    /** @var UtilityService */
    protected UtilityService $utilityService;
    /* @var array */
    protected array $config;

    /** @var MetaService */
    protected MetaService $metaService;

    /** @var ItemService */
    protected ItemService $itemService;

    public function __construct(
        AccountService      $accountService,
        UtilityService      $utilityService,
                            MetaService     $metaService,
                            ItemService     $itemService,
                            $config
    )
    {
        $this->accountService   = $accountService;
        $this->utilityService   = $utilityService;
        $this->metaService      = $metaService;
        $this->itemService      = $itemService;
        $this->config           = $config;
    }

    public function getItemList(object|array $params): array
    {
        return $this->itemService->getItemList($params);

    }

    public function getItem(object|array $requestBody): array
    {
        $requestBody['type'] = $requestBody['type']??'';
        return $this->itemService->getItem($requestBody[$requestBody['type']],$requestBody['type']);
    }

    public function addItem(object|array $requestBody, mixed $account): object|array
    {
        $requestBody['time_create'] = time();
        $requestBody['slug'] = 'support-'.$account['id'].'-'.uniqid();
        $params=[
            'slug' => $requestBody['slug'],
            'user_id' =>  $requestBody['user_id'] ,
            'type' =>  $requestBody['type'],
            'status' => $requestBody['status'],
            'time_create' => $requestBody['time_create'],
        ];
        $requestBody['history'][] =$requestBody;
        $requestBody['conversation'] =[];

        $params['information'] = json_encode($requestBody);
        return $this->itemService->addItem($params,$account);
    }

    public function updateItem(object|array $requestBody, mixed $account)
    {
        $item =  $this->itemService->getItem($requestBody['slug'],'slug');
        $requestBody['time_update'] = time();
        $params=[
            'slug' => $requestBody['slug'],
            'user_id' =>  $requestBody['user_id'] ,
            'status' => $requestBody['status']??1,
            'time_create' => $requestBody['time_update'],
        ];
        $params['information'] = json_encode($requestBody);
        return $this->itemService->editItem($params,$account);

    }

    public function editItem(object|array|null $requestBody, mixed $account): object|array|null
    {
        $item =  $this->itemService->getItem( $requestBody['slug'] ,'slug');
        $params = $item;
        $params['time_update'] = time();
        $requestBody['time_update'] =$params['time_update'];
        $requestBody['time_update_view'] = $this->utilityService->date($requestBody['time_update']);
        $params['history'][] = $requestBody;

        if(isset($requestBody['order_status'])){
            $params['order']['status'] = $requestBody['status'];
        }

        if(isset($requestBody['follow_up_date'])){
            $params['follow_up_date'] = $requestBody['follow_up_date'];
        }


        $request =[
          'slug' => $requestBody['slug'],
          'id' => $requestBody['id'],
          'information' => json_encode($params),
          'time_update' => $params['time_update'],
        ];

        return $this->itemService->editItem($request);

    }

}
