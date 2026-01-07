<?php

use Laravel\Mcp\Facades\Mcp;
use App\Mcp\Servers\WeatherServer;

Mcp::web('/mcp/demo', WeatherServer::class);
