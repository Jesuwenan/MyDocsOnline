<template>
  <div class="min-h-screen text-center flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <img :src="header.img" alt="" class="h-64 w-64">
    <h1 class="font-bold text-xl uppercase">{{header.title}}</h1>
    <p class="mb-3">{{description}}</p>
    <inertia-link class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :href="route('login')">
      Revenir en lieu sur
    </inertia-link>
  </div>
</template>

<script>

import LoadingButton from '@/Shared/LoadingButton'
export default {

    components: {
        LoadingButton
    },
    props: {
      status: Number,
    },
    //layout: AppLayout,
    data() {
      return {
      }
    },
    computed: {
      header() {
        return {
          503: {
            title: 'Service Unavailable',
            img: '/img/errors/error.png'
          },
          500: {
            title: 'Server Error',
            img: '/img/errors/500.png'
          },
          403: {
            title: 'Forbidden',
            img: '/img/errors/error.png'
          },
          404: {
            title: 'Page Not Found',
            img: '/img/errors/404.png'
          },
        }[this.status]
      },
      description() {
        return {
          503: 'Désolé, nous effectuons des travaux de maintenance. Veuillez revenir bientôt.',
          500: 'Oups, quelque chose s\'est mal passé sur nos serveurs.',
          404: 'Désolé, la page que vous recherchez n\'a pas pu être trouvée.',
          403: 'Désolé, l\'accès à cette page vous est interdit.',
        }[this.status]
      },
    }

}
</script>