@include('errors.layout', ['code' => $exception->getStatusCode() ?? '5xx', 'message' => 'Something broke on this end, not yours.'])
