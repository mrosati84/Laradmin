<?php

return array(

    // namespace for your admin classes. add it to your composer.json!
    'namespace' => 'Acme',

    // route prefix for the administrator
    'prefix' => 'admin',

    // html <title> for the administrator
    'title' => 'Backend',

    // the default entity handled by Laradmin
    'defaultEntity' => 'Post',

    // authentication callable
    'authCallable' => function() {
        return true;
    },

    // set pagination. default is 10 results per page
    'paginate' => 3,

    // redirect to this route name if authentication fails
    'authRedirectRoute' => 'login',

    // BEGIN: managed entities list
    'entities' => array(
        'Post' => array(
            'fields' => array(
                'title' => array(
                    'type' => 'string',
                    'label' => 'Post title'
                ),
                'body' => array(
                    'type' => 'text',
                    'label' => 'Post body'
                ),
                'comments' => array(
                    'type' => 'HasMany:Comment:body',
                    'label' => 'Comments'
                ),
                'user' => array(
                    'type' => 'BelongsTo:User:email',
                    'label' => 'Author'
                ),
                'tags' => array(
                    'type' => 'BelongsToMany:Tag:title',
                    'label' => 'Tags'
                ),
                'created_at' => array(
                    'type' => 'datetime',
                    'label' => 'Creation date'
                ),
                'updated_at' => array(
                    'type' => 'datetime',
                    'label' => 'Last update'
                )
            )
        ),

        'Comment' => array(
            'fields' => array(
                'body' => array(
                    'type' => 'text',
                    'label' => 'Comment body'
                ),
                'post' => array(
                    'type' => 'BelongsTo:Post:title',
                    'label' => 'Post'
                )
            )
        ),

        'Tag' => array(
            'fields' => array(
                'title' => array(
                    'type' => 'string',
                    'label' => 'Title'
                ),
                'posts' => array(
                    'type' => 'BelongsToMany:Post:title',
                    'label' => 'Posts'
                )
            )
        ),

        'User' => array(
            'fields' => array(
                'email' => array(
                    'type' => 'email',
                    'label' => 'E-mail'
                ),
                'password' => array(
                    'type' => 'password',
                    'label' => 'Password'
                ),
                'phone' => array(
                    'type' => 'HasOne:Phone:number',
                    'label' => 'Phone number'
                ),
                'posts' => array(
                    'type' => 'HasMany:Post:title',
                    'label' => 'Posts'
                )
            )
        ),

        'Phone' => array(
            'fields' => array(
                'number' => array(
                    'type' => 'string',
                    'label' => 'Phone number'
                ),
                'user' => array(
                    'type' => 'BelongsTo:User:email',
                    'label' => 'User'
                )
            )
        )
    )
    // END: managed entities list

);
