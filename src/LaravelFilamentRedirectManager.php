<?php

namespace Novius\LaravelFilamentRedirectManager;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Support\Arr;

class LaravelFilamentRedirectManager implements Plugin
{
    protected bool $softDeletes = false;

    /**
     * @var array<string, class-string>
     */
    protected array $models = [];

    /**
     * @var array<string, class-string>
     */
    protected array $resources = [];

    public static function make(): self
    {
        $instance = new self;
        $config = config('laravel-filament-redirect-manager', []);
        $instance->overrideResources($config['resources']);

        return $instance;
    }

    public static function getPlugin(): self
    {
        /** @phpstan-ignore return.type */
        return filament('laravel-filament-redirect-manager');
    }

    public function getId(): string
    {
        return 'laravel-filament-redirect-manager';
    }

    public function register(Panel $panel): void
    {
        $panel->resources($this->resources);
    }

    /**
     * @param  array<string,class-string|null>  $overrides
     */
    public function overrideResources(array $overrides): self
    {
        $resources = array_merge($this->resources, $overrides);
        $this->resources = Arr::whereNotNull($resources);

        return $this;
    }

    public function getResource(string $resource): string
    {
        return $this->resources[$resource];
    }

    public function boot(Panel $panel): void {}
}
