<?php


class Market {
    private $bearerToken = null;

    private function convertCurlDataArrayToString($data, $delimiter = '--------') {
        return implode($delimiter, array_map(
                static function ($v, $k) {
                    if (is_array($v)){
                        return $k.'[]='.implode('&'.$k.'[]=', $v);
                    }

                    return $k.'='.$v;
                }, $data, array_keys($data) )
        );
    }

    /**
     * На основе базового токена получим BEARER для последующего использования в API запросах.
     * @return mixed|null
     */
    private function getBearerToken() : void {
        $curl = curl_init();

        $basicToken = MARKET_BASIC_TOKEN;

        curl_setopt_array( $curl, array(
            CURLOPT_URL            => 'https://market-internal-api-test.evotor.ru/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => 'grant_type=client_id',
            CURLOPT_HTTPHEADER     => array(
                'Content-Type: application/x-www-form-urlencoded',
                "Authorization: Basic $basicToken"
            ),
        ) );

        $response = curl_exec( $curl );

        //
        $status = curl_getinfo( $curl );
        $stringStatus = $this->convertCurlDataArrayToString($status);
        //
        curl_close( $curl );

        try {
            error_log( $response );
            error_log( $stringStatus );
            //
            $data              = json_decode( $response, true, 512, JSON_THROW_ON_ERROR );
            $this->bearerToken = $data['access_token'];
        } catch ( JsonException $e ) {
            error_log($e);
            error_log( 'Error decoding a response from the market, upon receipt of Bearer tokens. ' );
        }
    }

    /**
     * Проверяет, где выполняется скрипт, на локальной dev-машине, или на production сервере
     *
     * @param string $url - в котором необходимо заменять адрес.
     *
     * @return string
     */
    private function replaceLocalDevAddressToProduction(string $url) : string {
        $newUrl = $url;

        if (LOCAL_DEV_ADDRESS) {
            return  str_replace(get_site_url(), 'https://zhiza.evotor.ru', $url);
        }

        return $newUrl;
    }


    public function saveImage(string $postID, string $imgUrl) {
        $id_market_post = get_field('id_market_post', $postID);
        $url_image_market_post = get_field('url_image_market_post', $postID);

        if (!empty($url_image_market_post)) {
            return $url_image_market_post;
        }

        $url = $imgUrl;
        $uploads = wp_upload_dir();
        $file_path = str_replace( $uploads['baseurl'], $uploads['basedir'], $url );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://market-internal-api-test.evotor.ru/api/v1/feed/files',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('multipartFile'=> new CURLFILE($file_path)),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->bearerToken,
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        try {
            error_log( $response );
            error_log( $stringStatus );
            //
            $data = json_decode( $response, true, 512, JSON_THROW_ON_ERROR );
            //
            return $data['imageUrl'];
        } catch ( JsonException $e ) {
            error_log($e);
            error_log( 'Error decoding a response from the market, upon receipt of Bearer tokens. ' );
        }

        return null;
    }


    public function createPost(array $opts) : bool {
        $this->getBearerToken();
        //
        if (is_null($this->bearerToken)) {
            error_log('We cant proceed export post without Bearer token.');
            return false;
        }
        //
        $imgUrl = $this->saveImage($opts['ID'], $opts['imgUrl']);
        //
        if (is_null($imgUrl)) {
            error_log('We cant proceed export post without Post Img url');
            return false;
        }
        //
        if (get_field('id_market_post', $opts['ID'])) {
            error_log('This post already uploaded. [ID = ' . $opts['ID'] . '].');
            return false;
        }
        //
        $payload = [
            'title'       => $opts['title'],
            'description' => $opts['description'],
            'categoryId'  => $opts['categoryId'],
            'type'        => 'INTERNAL',
            'status'      => 'ACTIVE',
            'accessType'  => 'PUBLIC',
            'buttonTitle' => $opts['buttonTitle'],
            'buttonUrl'   => null,
            'imgUrl'      => $imgUrl,
            'content'     => $opts['content']
        ];

        $curl = curl_init();

        try {
            $encodedPayload = json_encode( $payload, JSON_THROW_ON_ERROR );
        } catch ( Exception $ex ) {
            error_log( "Error encoding payload to JSON format for post (" . $opts['ID'] . ") : " . $opts['title'] );
            return false;
        }

        curl_setopt_array( $curl, array(
            CURLOPT_URL            => 'https://market-internal-api-test.evotor.ru/api/v1/feed/feeds',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $encodedPayload,
            CURLOPT_HTTPHEADER     => array(
                'Content-Type: application/json',
                'Accept: application/json, text/plain, */*',
                'Origin: market-internal-api-test.evotor.ru',
                "Authorization: Bearer $this->bearerToken",
            ),
        ) );

        $response = curl_exec( $curl );

        curl_close( $curl );

        try {
            error_log( $response );
            error_log( $stringStatus );
            //
            $data = json_decode( $response, true, 512, JSON_THROW_ON_ERROR );
            //
            $newPostId = $data['id'];
            $this->updatePostMeta($opts['ID'], $newPostId, $imgUrl);
        } catch ( JsonException $e ) {
            error_log($e);
            error_log( 'Error decoding a response from the market, upon receipt of Bearer tokens. ' );
        }

        return true;
    }

    private function updatePostMeta($wpPostId, $marketPostId, $marketImgUrl) {
        update_post_meta(
            $wpPostId,
            'id_market_post',
            $marketPostId,
        );
        //
        update_post_meta(
            $wpPostId,
            'url_image_market_post',
            $marketImgUrl,
        );
    }
}
