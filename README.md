# okta-jwt-verifier-php-example

## Installation

```
git clone https://github.com/AmpersandHQ/okta-jwt-verifier-php-example
cd okta-jwt-verifier-php-example
composer install
```

## Usage

Run like so, but replace the URL with your valid okta URL
```
$ php request.php https://dev-12345.okta.com/oauth2/default/v1/keys
Sent request to https://dev-12345.okta.com/oauth2/default/v1/keys
Duration 0.85608506202698
```

## Caveats

This will show a little additional runtime than the raw request due to the call also running `self::parseKeySet` but most of the duration is in the actual requesting of data

```php
public function getKeys($jku)
{
    $keys = json_decode($this->request->setUrl($jku)->get()->getBody()->getContents());
    return self::parseKeySet($keys);
}
```

This is corroborated by using `curl` and seeing most of the time spent in `appconnect` and `connect` 
```bash
$ curl -XGET -H 'Accept: application/json'  -w '\n\ntime_total: %{time_total}s\ntime_appconnect: %{time_appconnect}s\ntime_connect: %{time_connect}s\ntime_namelookup: %{time_namelookup}s\ntime_pretransfer: %{time_pretransfer}s\ntime_redirect: %{time_redirect}s\ntime_starttransfer: %{time_starttransfer}s\n'  https://dev-12345.okta.com/oauth2/default/v1/keys

time_total: 0.847052s
time_appconnect: 0.507512s
time_connect: 0.194617s
time_namelookup: 0.051206s
time_pretransfer: 0.507746s
time_redirect: 0.000000s
time_starttransfer: 0.846858s
```

```bash
time_appconnect
    The time, in seconds, it took from the start until the SSL/SSH/etc connect/handshake to the remote host was completed. 

time_connect   
    The time, in seconds, it took from the start until the TCP connect to the remote host (or proxy) was completed.
```
