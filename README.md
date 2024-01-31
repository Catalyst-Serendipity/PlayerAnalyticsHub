# PlayerAnalyticsHub

PlayerAnalyticsHub provides methods for managing and retrieving player statistics within a Minecraft Bedrock server environment. This API integrates seamlessly with SQLite databases, allowing developers to efficiently store and query player data for various analytical purposes.

## Usage

```php
PlayerAnalyticsHubAPI::updatePlayerStatistic(Player $player, string $stats, int $value = 1) : void
```

Updates the specified player's statistic with the given value.

- **Parameters:**
  - `$player` (Player): The player whose statistic is to be updated.
  - `$stats` (string): The name of the statistic to update.
  - `$value` (int): The value to update the statistic with (default: 1).

- **Return Type:** void

```php
PlayerAnalyticsHubAPI::getPlayerStatistic(Player $player, string $stats) : array
```

Retrieves the statistic for the specified player and statistic name.

- **Parameters:**
  - `$player` (Player): The player whose statistic is to be retrieved.
  - `$stats` (string): The name of the statistics to retrieve.

- **Return Type:** array

```php
PlayerAnalyticsHubAPI::getAllPlayerStatistics(Player $player) : array
```

Retrieves all statistics for the specified player.

- **Parameters:**
  - `$player` (Player): The player whose statistics is to be retrieved.

- **Return Type:** array

```php
PlayerAnalyticsHubAPI::getTopStatistics(string $stats) : array
```

Retrieves the top statistics for the specified statistic name.

- **Parameters:**
  - `$stats` (string): The name of the top statistics to retrieve.

- **Return Type:** array

## Integration

To integrate the Player Statistics API into your plugin or server, follow these steps:

1. Include the necessary classes and methods from the API into your codebase.
2. Utilize the provided methods to update, retrieve, and manage player statistics as needed.
3. Ensure proper error handling for database queries and data retrieval operations.
4. Customize the API methods and parameters according to your specific use case and requirements.

## Example

```php
// Update player statistic
PlayerAnalyticsHubAPI::updatePlayerStatistic($player, "kills", 1);

// Retrieve player statistic
$stats = PlayerAnalyticsHubAPI::getPlayerStatistic($player, "kills");

// Retrieve all player statistics
$allStats = PlayerAnalyticsHubAPI::getAllPlayerStatistics($player);

// Retrieve top statistics
$topStats = PlayerAnalyticsHubAPI::getTopStatistics("kills");

// Example how to retrieve statistics values
foreach($topStats as $rank => $top){
    // Player statistics rank -> $rank
    // Player statistics username -> $top["player"]
    // Player statistics value -> $top["stat_value"]
    ++$rank;
    Server::getInstance()->broadcastMessage("#{$rank} " . $top["player"] . " kills : " . $top["stat_value"]);

    // Example output:
    // #1 Steve kills : 100
}
```

## Notes

- Make sure to configure the SQLite database connection and queries according to your server environment and database structure.
- Implement proper caching mechanisms and optimizations to ensure efficient data retrieval and processing.
- Keep the API methods and parameters consistent with your application's design and functionality.
- Regularly monitor and analyze player statistics to gain insights into player behavior and server performance.
- Refer to the documentation and code comments for detailed information on each API method and parameter.

---

Feel free to customize and expand the README as needed to provide additional context, usage examples, or instructions for developers integrating the API into their projects.