<?php

namespace Luilliarcec\Utilities\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuthScope
{
    protected array $extensions = ['withoutAuth'];

    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedAuthIdColumn(), Auth::id());
    }

    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    protected function addWithoutCompany(Builder $builder)
    {
        $builder->macro('withoutAuth', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
