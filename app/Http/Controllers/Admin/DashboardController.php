<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct() {
        
    }

    public function index() {
        
        $config = $this->config();
        $template = 'admin.dashboard.home.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    private function config() {
        return [
            'js' => [
                'admin/js/plugins/flot/jquery.flot.js',
                'admin/js/plugins/flot/jquery.flot.tooltip.min.js',
                'admin/js/plugins/flot/jquery.flot.spline.js',
                'admin/js/plugins/flot/jquery.flot.resize.js',
                'admin/js/plugins/flot/jquery.flot.pie.js',
                'admin/js/plugins/flot/jquery.flot.symbol.js',
                'admin/js/plugins/flot/jquery.flot.time.js',
                'admin/js/plugins/peity/jquery.peity.min.js',
                'admin/js/demo/peity-demo.js',
                'admin/js/inspinia.js',
                'admin/js/plugins/pace/pace.min.js',
                'admin/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js',
                'admin/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
                'admin/js/plugins/easypiechart/jquery.easypiechart.js',
                'admin/js/plugins/sparkline/jquery.sparkline.min.js',
                'admin/js/demo/sparkline-demo.js',
            ]
        ];
    }
}
