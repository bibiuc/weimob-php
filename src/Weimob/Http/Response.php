<?php


namespace Kiduc\Weimob\Http;

use Kiduc\Weimob\Exception\ApiException;

class Response
{public $okay;
    public $body;
    public $forApi;
    public $messages = [];

    private $requestObject;

    public function setRequestObject($requestObject)
    {
        $this->requestObject = $requestObject;
    }

    public function getRequestObject()
    {
        return $this->requestObject;
    }

    private function parsePaystackResponse()
    {
        $resp = \json_decode($this->body, true);

        if ($resp === null || isset($resp['error']) ) {
            throw new ApiException(
                "Paystack Request failed with response: '" .
                $this->messageFromApiJson($resp)."'",
                $resp,
                $this->requestObject
            );
        }

        return $resp;
    }

    private function messageFromApiJson($resp)
    {
        $message = $this->body;
        if ($resp !== null) {
            if (isset($resp['error_description'])) {
                $message = $resp['error_description'];
            }
            if (isset($resp['error'])) {
                $message .= "\n".$resp['error'];
            }
        }
        return $message;
    }

    private function implodedMessages()
    {
        return implode("\n\n", $this->messages);
    }

    public function wrapUp()
    {
        if ($this->okay && $this->forApi) {
            return $this->parsePaystackResponse();
        }
        if (!$this->okay && $this->forApi) {
            throw new \Exception($this->implodedMessages());
        }
        if ($this->okay) {
            return $this->body;
        }
        error_log($this->implodedMessages());
        return false;
    }
}
