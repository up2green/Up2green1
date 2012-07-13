<?php
class up2gYahooOAuth extends sfOAuth1
{
  public function call($url, $params = array(), $method = 'GET') {
    $consumer = $this->getConsumer();

    date_default_timezone_set('America/New_York');

    $request = OAuthRequest::from_consumer_and_token($consumer, NULL,$method, $url, $params);

    // adjust timestamp ...
    $timestamp = $request->get_parameter('oauth_timestamp');
//    $timestamp += 600;
    $request->set_parameter('oauth_timestamp', $timestamp, false);

    $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);
    $url = sprintf("%s?%s", $url, OAuthUtil::build_http_query($params));
    $ch = curl_init();
    $headers = array($request->to_header());

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    return curl_exec($ch);
  }
}