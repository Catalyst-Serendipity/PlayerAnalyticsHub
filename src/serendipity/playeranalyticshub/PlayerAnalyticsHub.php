<?php

/**
 * Copyright (c) 2024 Catalyst-Serendipity
 *      ______      __        __           __       _____                          ___       _ __       
 *     / ____/___ _/ /_____ _/ /_  _______/ /_     / ___/___  ________  ____  ____/ (_)___  (_) /___  __
 *    / /   / __ `/ __/ __ `/ / / / / ___/ __/_____\__ \/ _ \/ ___/ _ \/ __ \/ __  / / __ \/ / __/ / / /
 *   / /___/ /_/ / /_/ /_/ / / /_/ (__  ) /_/_____/__/ /  __/ /  /  __/ / / / /_/ / / /_/ / / /_/ /_/ / 
 *   \____/\__,_/\__/\__,_/_/\__, /____/\__/     /____/\___/_/   \___/_/ /_/\__,_/_/ .___/_/\__/\__, /  
 *                          /____/                                                /_/          /____/   
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author  Catalyst Serendipity Team
 * @email   catalystserendipity@gmail.com
 * @link    https://github.com/Catalyst-Serendipity
 * 
 */

declare(strict_types=1);

namespace serendipity\playeranalyticshub;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use serendipity\playeranalyticshub\data\database\IDatabase;
use serendipity\playeranalyticshub\data\database\sqlite\SQLiteDatabase;

class PlayerAnalyticsHub extends PluginBase{
    use SingletonTrait;

    private IDatabase $database;

    protected function onLoad() : void{
        $this->saveDefaultConfig();
    }

    protected function onEnable() : void{
        self::setInstance($this);

        $this->database = new SQLiteDatabase($this);
    }

    protected function onDisable() : void{
        if($this->database !== null){
            $this->database->close();
        }
    }

    public function getDatabase() : IDatabase{
        return $this->database;
    }
}