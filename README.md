# Coin Trader

To start add you bittrex api key and secret to the configuration file `/etc/app.configuration.php.dist` and remove the `.dist` extension from the file. After that you can use the cli tool as shown below.

`php ./app/cli.php <command>`

Available commands:
  
  `php ./app/cli.php currencies`: Get all supported currencies at Bittrex along with other meta data.
  
  `php ./app/cli.php market-summaries`: Get the last 24 hour summary of all active exchanges.
  
  `php ./app/cli.php market-summaries -m BTC-NLG`: Get the last 24 hour summary for the BTC-NLG exchange.
  
  `php ./app/cli.php markets`: Get the open and available trading markets at Bittrex along with other meta data.
  
  `php ./app/cli.php order-book -m BTC-NLG`: Get the current tick values for a market, e.g. BTC-NLG market.
  
  `php ./app/cli.php ticker -m BTC-NLG`: Get the current tick values for a market, e.g. BTC-NLG market.
