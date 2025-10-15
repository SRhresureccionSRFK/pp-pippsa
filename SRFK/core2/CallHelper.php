<?php

class CallHelper {
    public static function safeCall(callable $callback, array $args = []): mixed {
        try {
            if (is_callable($callback)) {
                return call_user_func_array($callback, $args);
            }
            throw new \Exception("Callback no invocable");
        } catch (\Throwable $e) {
//            Response::error(500, "[SRFK++] Callback error: " . $e->getMessage());
        }
        return null;
    }
}
