<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Utils\User;

class SetAttributesUppercaseTest extends TestCase
{
    function test_case_is_applied()
    {
        $user = new User(['name' => 'luis arce']);
        $this->assertEquals('LUIS ARCE', $user->name);

        $user->fill(['name' => 'andrés arce']);
        $this->assertEquals('ANDRÉS ARCE', $user->name);

        $user->name = 'pizza';
        $this->assertEquals('PIZZA', $user->name);

        $user->setAttribute('name', 'rolling stones');
        $this->assertEquals('ROLLING STONES', $user->name);
    }

    function test_dont_apply_to_unwanted_attributes()
    {
        $user = new User(['name' => 'luis arce']);
        $this->assertEquals('LUIS ARCE', $user->name);

        $user->username = 'larcec';
        $this->assertEquals('larcec', $user->username);
    }

    function test_dont_apply_to_sensitive_attributes()
    {
        $user = new User(['name' => 'luis arce', 'password' => 'root']);
        $this->assertEquals('LUIS ARCE', $user->name);
        $this->assertEquals('root', $user->password);
    }

    function test_dont_apply_to_globally_ignored_attributes()
    {
        $user = new User();
        $user->url = 'doctor.hoo';
        $this->assertEquals('DOCTOR.HOO', $user->url);

        $this->app['config']->set('utilities.attributes_ignored_globally', [
            'url',
        ]);

        $user->url = 'doctor.hoo';
        $this->assertEquals('doctor.hoo', $user->url);
    }
}
