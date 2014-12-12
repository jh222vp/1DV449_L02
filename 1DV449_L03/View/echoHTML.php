<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2014-12-11
 * Time: 11:36
 */
class echoHTML
{
    public function echoHTML()
    {
        $ret = "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <link href='./Style/style.css' rel='stylesheet'>
            <link href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css' rel='stylesheet'>
            <title>Jonas Trafikapplikation</title>
        </head>
        <body>
        <div class='container container-fluid'>

        <div class='alert alert-info'>
        <a href=''#' class='close' data-dismiss='alert'>&times;</a>
        <strong>Info!</strong> Välkommen till Jonas trafiksida.
        </div>


        <select id='SelectList' class='btn btn-primary'>
            <option value='4'>Alla meddelanden</option>
            <option value='0'>Vägtrafik</option>
            <option value='1'>Kollektivtrafik</option>
            <option value='2'>Planerade störningar</option>
            <option value='3'>Övrigt</option>

        </select>

        <div class='row'>

        <div id='index'>
        <div id = 'box' class='col-md-5'>
        </div>
        </div>

        <div id='map-canvas' class='col-md-5'>
        </div>

        </div>
        </div>

        <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyAXnIpJZtmtzoky9ba0KLXhk-PsT7vRb8E'></script>
        <script src='js/Map.js'></script>
        <script src='js/jquery-1.10.2.min.js'></script>
        <script src='js/Traffic.js'></script>
        </body>
        </html>";

        return $ret;
    }
}