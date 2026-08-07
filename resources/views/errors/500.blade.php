@include('errors.layout', [
    'code' => '500',
    'message' => 'Something broke on this end, not yours.',
    'description' => "The machinery behind the scenes hit a problem. Nothing for you to fix here."
])
