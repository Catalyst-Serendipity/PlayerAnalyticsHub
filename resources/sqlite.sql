-- #!sqlite
-- #{ init
CREATE TABLE IF NOT EXISTS playerstats (
	player TEXT PRIMARY KEY COLLATE NOCASE,
	stat_name TEXT,
	stat_value INTEGER
);
-- #&
CREATE INDEX IF NOT EXISTS playerstats_index ON playerstats (stat_name);
-- #}
-- #{ update
-- #	:player string
-- #	:stats string
-- #	:value int
INSERT OR IGNORE INTO playerstats (player, stat_name, stat_value) VALUES (:player, :stats, 0);
-- #&
UPDATE playerstats SET stat_value = :value WHERE player = :player AND stat_name = :stats;
-- #}
-- #{ get_player_stats
-- #	:player string
-- #	:stats string
SELECT stat_value FROM playerstats WHERE player = :player AND stat_name = :stats;
-- #}
-- #{ get_player_data_stats
-- #	:player string
SELECT stat_name, stat_value FROM playerstats WHERE player = :player;
-- #}
-- #{ top
-- #	:limit int
-- #	:stats string
SELECT player, stat_name, stat_value FROM playerstats WHERE stat_name = :stats ORDER BY stat_value DESC LIMIT :limit;
-- #}