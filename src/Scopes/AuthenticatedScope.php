<?php

namespace Luilliarcec\Utilities\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class AuthenticatedScope implements Scope
{
    protected array $extensions = ['WithoutAuth'];

    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedAuthKeyNameColumn(), Auth::id());
    }

    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    protected function addWithoutAuth(Builder $builder)
    {
        $builder->macro('withoutAuth', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
