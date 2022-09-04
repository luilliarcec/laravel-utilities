<?php

namespace Luilliarcec\Utilities\Rules;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;

class Authenticated
{
    public function __construct(
        protected string $table,
        protected string $column = 'NULL',
        protected string|null $authenticatedKeyName = null
    ) {
    }

    public static function make(
        string $table,
        string $column = 'NULL',
        string|null $authenticatedKeyName = null
    ): static {
        return new self($table, $column, $authenticatedKeyName);
    }

    public function column(string $column): static
    {
        $this->column = $column;

        return $this;
    }

    public function authenticatedKeyName(string $key): static
    {
        $this->authenticatedKeyName = $key;

        return $this;
    }

    protected function getTable(): string
    {
        return $this->table;
    }

    protected function getColumn(): string
    {
        return $this->column;
    }

    protected function getAuthenticatedKeyName(): string
    {
        if ($this->authenticatedKeyName) {
            return $this->authenticatedKeyName;
        }

        if (method_exists($table = $this->getTable(), 'getAuthenticatedKeyNameColumn')) {
            return (new $table)->getAuthenticatedKeyNameColumn();
        }

        return (string) config('utilities.authenticated.key');
    }

    public function exists(): Exists
    {
        return (new Exists($this->getTable(), $this->getColumn()))
            ->where($this->getAuthenticatedKeyName(), Auth::id());
    }

    public function unique(): Unique
    {
        return (new Unique($this->getTable(), $this->getColumn()))
            ->where($this->getAuthenticatedKeyName(), Auth::id());
    }
}
