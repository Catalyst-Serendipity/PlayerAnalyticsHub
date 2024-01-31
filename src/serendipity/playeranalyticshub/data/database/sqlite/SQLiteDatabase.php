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

namespace serendipity\playeranalyticshub\data\database\sqlite;

use pocketmine\player\Player;
use poggit\libasynql\libasynql\DataConnector;
use poggit\libasynql\libasynql\libasynql;
use poggit\libasynql\libasynql\SqlError;
use serendipity\playeranalyticshub\data\database\IDatabase;
use serendipity\playeranalyticshub\PlayerAnalyticsHub;

class SQLiteDatabase implements IDatabase{

    private DataConnector $db;

    public function getName() : string{
        return "sqlite";
    }

    public function __construct(
        protected PlayerAnalyticsHub $plugin
    ){
        $this->plugin = $plugin;
        $this->db = libasynql::create($plugin, $plugin->getConfig()->get("database"), [
            "sqlite" => "sqlite.sql"
        ]);
        $this->db->executeGeneric(SQLiteQuery::INIT_DATA);
        $this->db->setLoggingQueries(true);
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
    public function updatePlayerStatistic(Player $player, string $stats, int $value = 1) : void{
        $lastValue = $this->getPlayerStatistic($player, $stats)["stat_value"];
        $value += $lastValue;
        $this->db->executeInsert(SQLiteQuery::UPDATE_DATA, [
            "player" => $player->getName(),
            "stats" => $stats,
            "value" => $value
        ], null, fn(SqlError $err) => $this->plugin->getLogger()->error($err->getMessage()));
    }

    /**
     * Retrieves the statistic for the specified player and statistic name.
     * 
     * @param Player $player    The player whose statistic is to be retrieved.
     * @param string $stats     The name of the statistics to retrieve.
     * 
     * @return array            Returns an array containing statistics for the specified player stats.
     */
    public function getPlayerStatistic(Player $player, string $stats) : array{
        $playerStatistic = [];
        $this->db->executeSelect(SQLiteQuery::GET_DATA, [
            "player" => $player->getName(),
            "stats" => $stats
        ], function(array $rows) use(&$playerStatistic) : void{
            $playerStatistic = $rows[0];
        }, fn(SqlError $err) => $this->plugin->getLogger()->error($err->getMessage()));
        $this->db->waitAll();
        return $playerStatistic;
    }

    /**
     * Retrieves all statistics for the specified player.
     * 
     * @param Player $player    The player whose statistics is to be retrieved.
     * 
     * @return array            Returns an array containing all statistics for the specified player.
     */
    public function getAllPlayerStatistics(Player $player) : array{
        $playerStatistics = [];
        $this->db->executeSelect(SQLiteQuery::GET_PLAYER_DATA, [
            "player" => $player->getName()
        ], function(array $rows) use(&$playerStatistics) : void{
            $playerStatistics = $rows;
        }, fn(SqlError $err) => $this->plugin->getLogger()->error($err->getMessage()));
        $this->db->waitAll();
        return $playerStatistics;
    }

    /**
     * Retrieves the top statistics for the specified statistic name.
     * 
     * @param string $stats     The name of the top statistics to retrieve.
     * 
     * @return array            Returns an array containing a limited list of top statistics with the specified name.
     */
    public function getTopStatistics(string $stats) : array{
        $topStats = [];
        $this->db->executeSelect(SQLiteQuery::TOP_DATA, [
            "limit" => $this->plugin->getConfig()->get("limit"),
            "stats" => $stats
        ], function(array $rows) use(&$topStats) : void{
            $topStats = $rows;
        }, fn(SqlError $err) => $this->plugin->getLogger()->error($err->getMessage()));
        $this->db->waitAll();
        return $topStats;
    }

    public function close() : void{
        $this->db->waitAll();
        $this->db->close();
    }
}