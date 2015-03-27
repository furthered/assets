<?php

namespace Assets\AssetType;

class JS extends AssetType {

    protected $angular_app;

    protected $lib = [
        'angular'         => '/bower_components/angular/angular.min.js',
        'lodash'          => '/bower_components/lodash/lodash.min.js',
        'modernizr'       => '/libraries/modernizr.min.js',
        'responsive-menu' => '/libraries/responsive-menu.js',
        'angular-animate' => '/bower_components/angular-animate/angular-animate.min.js',
        'angular-route'   => '/bower_components/angular-route/angular-route.min.js',
        'datepicker'      => '/bower_components/ngQuickDate/dist/ng-quick-date.min.js',
        'firebase'        => '/bower_components/firebase/firebase.js',
    ];

    protected function addDefaults()
    {
        $this->add([
            'angular',
            'lawline',
            'modernizr',
            'responsive-menu'
        ]);

        $this->setAngularApp('Lawline');
    }

    protected function getDir()
    {
        return 'js/apps';
    }

    protected function getExtension()
    {
        return '.js';
    }

    protected function getMainFile()
    {
        return 'app' . $this->getExtension();
    }

    protected function wrapInTag($path)
    {
        return '<script type="text/javascript" src="' . $path . '"></script>';
    }

    public function setAngularApp($app)
    {
        $this->angular_app = $app;
    }

    public function getAngularApp()
    {
        return $this->angular_app;
    }
}
