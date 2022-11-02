<?php

namespace App;

use Illuminate\Support\Arr;

trait Authorizable
{
    /**
     * @var array
     */
    private $abilities = [
        'index' => 'view',
        'edit' => 'edit',
        'show' => 'view',
        'update' => 'edit',
        'create' => 'add',
        'store' => 'add',
        'destroy' => 'delete',
    ];

    /**
     * Override of callAction to perform the authorization before
     *
     * @param $method
     * @param $parameters
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        if ($ability = $this->getAbility($method)) {
            $this->authorize($ability);
        }

        return parent::callAction($method, $parameters);
    }

    /**
     * @param $method
     *
     * @return string|null
     */
    public function getAbility($method): ?string
    {
        $routeName = explode('.', request()->route()->getName());
        $action = Arr::get($this->getAbilities(), $method);

        return $action ? $action.'_'.$routeName[1] : null;
    }

    /**
     * @return array
     */
    private function getAbilities(): array
    {
        return $this->abilities;
    }

    /**
     * @param $abilities
     */
    public function setAbilities($abilities): void
    {
        $this->abilities = $abilities;
    }
}
