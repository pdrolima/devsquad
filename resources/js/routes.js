export default [
    {
        path: '/home',
        name: 'home',
        component: require('./components/home').default
    },
    {
        path: '/products',
        name: 'products',
        component: require('./components/products/index').default
    },
    {
        path: '/products/create',
        name: 'products.create',
        component: require('./components/products/create').default
    },
    {
        path: '/products/import',
        name: 'products.import',
        component: require('./components/products/import').default
    },
    {
        path: '/products/:id',
        name: 'products.show',
        component: require('./components/products/show').default
    },
    {
        path: '/products/:id/edit',
        name: 'products.edit',
        component: require('./components/products/edit').default
    },
]   