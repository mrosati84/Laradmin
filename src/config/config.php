<?php

return array(

    // namespace for your admin classes. add it to your composer.json!
    'namespace' => 'Acme',

    // route prefix for the administrator
    'prefix' => 'admin',

    // html <title> for the administrator
    'title' => 'Backend',

    'defaultEntity' => 'Post',

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
            ),
            'filters' => array(),
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
            ),
            'filters' => array()
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
            ),
            'filters' => array()
        ),

        'User' => array(
            'fields' => array(
                'email' => array(
                    'type' => 'email',
                    'label' => 'E-mail'
                ),
                'phone' => array(
                    'type' => 'HasOne:Phone:number',
                    'label' => 'Phone number'
                ),
                'posts' => array(
                    'type' => 'HasMany:Post:title',
                    'label' => 'Posts'
                )
            ),
            'filters' => array()
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
            ),
            'filters' => array()
        )
    )
    // END: managed entities list

);
