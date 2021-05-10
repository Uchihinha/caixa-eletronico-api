<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;

trait HandlesAuthorization
{
    /**
     * Create a new access response.
     *
     * @param  string|null  $message
     * @param  mixed  $code
     * @return \Illuminate\Auth\Access\Response
     */
    protected function allow($message = null, $code = null)
    {
        return Response::allow($message, $code);
    }

    /**
     * Throws an unauthorized exception.
     *
     * @param  string|null  $message
     * @param  mixed|null  $code
     * @return \Illuminate\Auth\Access\Response
     */
    protected function deny($message = 'Você não tem permissão para esta ação!', $code = 403)
    {
        return Response::deny($message, $code);
    }
}
