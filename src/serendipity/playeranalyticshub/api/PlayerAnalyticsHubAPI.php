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

namespace serendipity\playeranalyticshub\api;

use pocketmine\player\Player;
use serendipity\playeranalyticshub\data\database\IDatabase;
use serendipity\playeranalyticshub\PlayerAnalyticsHub;

class PlayerAnalyticsHubAPI{

    /**
     * Retrieves the database instance for player analytics.
     * 
     * @return IDatabase        The database instance for player analytics.
     */
    public static function getDatabase() : IDatabase{
        return PlayerAnalyticsHub::getInstance()->getDatabase();
    }

    /**
     * Updates the statistic for the specified player with the given value.
     * 
     * @param Player $player    The player whose statistic is to be updated.
     * @param string $stats     The name of the statistic to update.
     * @param int $value        The value to update the statistic with.
     * 
     * @return void
     */
    public static function updatePlayerStatistic(Player $player, string $stats, int $value = 1) : void{
        self::getDatabase()->updatePlayerStatistic($player, $stats, $value);
    }

    /**
     * Retrieves the statistic for the specified player and statistic name.
     * 
     * @param Player $player    The player whose statistic is to be retrieved.
     * @param string $stats     The name of the statistics to retrieve.
     * 
     * @return array            Returns an array containing statistics for the specified player stats.
     */
    public static function getPlayerStatistic(Player $player, string $stats) : array{
        return self::getDatabase()->getPlayerStatistic($player, $stats);
    }

    /**
     * Retrieves all statistics for the specified player.
     * 
     * @param Player $player    The player whose statistics is to be retrieved.
     * 
     * @return array            Returns an array containing all statistics for the specified player.
     */
    public static function getAllPlayersStatistic(Player $player) : array{
        return self::getDatabase()->getAllPlayerStatistics($player);
    }

    /**
     * Retrieves the top statistics for the specified statistic name.
     * 
     * @param string $stats     The name of the top statistics to retrieve.
     * 
     * @return array            Returns an array containing a limited list of top statistics with the specified name.
     */
    public static function getTopStatistics(string $stats) : array{
        return self::getDatabase()->getTopStatistics($stats);
    }
}