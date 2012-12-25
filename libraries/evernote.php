<?php

class Evernote {

	public static function get_temporary_credentials()
	{
		$consumer_key       = Config::get('evernote.oauth_consumer_key');
		$consumer_secret    = Config::get('evernote.oauth_consumer_secret');
		$callback_url       = Config::get('evernote.callback_url');
		$request_token_url  = Config::get('evernote.evernote_server');
		$request_token_url .= Config::get('evernote.request_token_path');

		try {
			$oauth = new OAuth($consumer_key, $consumer_secret);
			$request_token_info = $oauth->getRequestToken($request_token_url, $callback_url);

			if ($request_token_info)
			{
				return array(
						'oauth_token'        => $request_token_info['oauth_token'],
						'oauth_token_secret' => $request_token_info['oauth_token_secret']
					);
			}
		} catch (OAuthException $e) {
			Log::error('Error obtaining temporary credentials: ' . $e->getMessage());
		}
	}


	public static function get_authorization_url($oauth_token)
	{
		$authorization_url  = Config::get('evernote.evernote_server');
		$authorization_url .= Config::get('evernote.authorization_path');
		$authorization_url .= '?oauth_token=';
		$authorization_url .= urlencode($oauth_token);
		return $authorization_url;
	}


	public static function get_token_credentials($oauth_verifier, $request_token, $request_token_secret)
	{
		$consumer_key      = Config::get('evernote.oauth_consumer_key');
		$consumer_secret   = Config::get('evernote.oauth_consumer_secret');
		$access_token_url  = Config::get('evernote.evernote_server');
		$access_token_url .= Config::get('evernote.access_token_path');

		try {
			$oauth = new OAuth($consumer_key, $consumer_secret);
			$oauth->setToken($request_token, $request_token_secret);
			$access_token_info = $oauth->getAccessToken($access_token_url, null, $oauth_verifier);
			if ($access_token_info)
			{
				return $access_token_info;
			}
			else
			{
				Log::error('Failed to obtain token credentials: '.$oauth->getLastResponse());
			}
		} catch (OAuthException $e) {
			Log::error('Error obtaining token credentials: ' . $e->getMessage());
		}		
	}


	protected static function create_note_store_client($notestore_url)
	{
		try {
			$parts = parse_url($notestore_url);
			$parts['port'] = $parts['scheme'] === 'https' ? 443 : 80;
			$note_store_trans = new THttpClient($parts['host'], $parts['port'], $parts['path'], $parts['scheme']);
			$note_store_prot  = new TBinaryProtocol($note_store_trans);
			$note_store       = new EDAM\NoteStore\NoteStoreClient($note_store_prot, $note_store_prot);
		} catch (Exception $e) {

		}
		return $note_store;
	}
}