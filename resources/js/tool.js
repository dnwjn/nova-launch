Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-launch',
      path: '/nova-launch',
      component: require('./views/Launch').default,
    },
  ])
})
