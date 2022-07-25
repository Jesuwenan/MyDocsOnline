<template>
    <div>
        <div class="fixed inset-0 flex z-40 lg:hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-blue-400 bg-opacity-75" aria-hidden="true"></div>
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-blue-400">
                <div class="absolute top-0 right-0 -mr-12 pt-2" @click="toggleMenu()">
                    <button
                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <!-- Heroicon name: outline/x -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-shrink-0 flex items-center">
                    <img class="h-full w-full" :src="baseUrl + '/img/LOGO.png'" alt="All docs Online">
                </div>
                <nav class="mt-5 flex-shrink-0 h-full divide-y divide-white overflow-y-auto" aria-label="Sidebar">
                    <div class="px-2 space-y-1">
                        <!-- <inertia-link :class="isUrl('companies') ? 'bg-gray-800 text-white group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md' : 'group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md text-white hover:text-white hover:bg-gray-700'" :href="route('documents.index')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                Entreprises
                            </inertia-link> -->

                        <!-- <inertia-link v-show="$page.props.user.is_admin" :class="isUrl('events') ? 'bg-gray-800 text-white group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md' : 'group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md text-white hover:text-white hover:bg-gray-700'" :href="route('events.index')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                    <path d="M7 15h0M2 9.5h20"/>
                                </svg>
                                Evénements
                            </inertia-link> -->

                        <inertia-link v-show="$page.props.user.is_admin"
                            :class="isUrl('users') ? 'bg-gray-800 text-white group flex items-center px-2 py-2 text-sm leading-6 font-medium' : 'group flex items-center px-2 py-2 text-sm leading-6 font-medium text-white hover:text-white hover:bg-gray-700'"
                            :href="route('users.index')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span v-if="!isLock">Utilisateurs</span>
                        </inertia-link>

                        <inertia-link
                            :class="isUrl('documents') ? 'bg-gray-800 text-white group flex items-center px-2 py-2 text-sm leading-6 font-medium' : 'group flex items-center px-2 py-2 text-sm leading-6 font-medium text-white hover:text-white hover:bg-gray-700'"
                            :href="route('documents.index')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6 text-white" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                <path d="M14 3v5h5M16 13H8M16 17H8M10 9H8" />
                            </svg>
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg> -->
                            <span v-if="!isLock">Documents</span>
                        </inertia-link>

                        <inertia-link
                            :class="isUrl('document_partagés') ? 'bg-gray-800 text-white group flex items-center px-2 py-2 text-sm leading-6 font-medium' : 'group flex items-center px-2 py-2 text-sm leading-6 font-medium text-white hover:text-white hover:bg-gray-700'"
                            :href="route('document_share.index')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                class="mr-4 h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                <path d="M14 3v5h5M12 18v-6M9 15h6" />
                            </svg><span v-if="!isLock">Documents Partagés</span>
                        </inertia-link>

                        <inertia-link
                            :class="isUrl('groups') ? 'bg-gray-800 text-white group flex items-center px-2 py-2 text-sm leading-6 font-medium' : 'group flex items-center px-2 py-2 text-sm leading-6 font-medium text-white hover:text-white hover:bg-gray-700'"
                            :href="route('groups.index')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                class="mr-4 h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                <path d="M14 3v5h5M12 18v-6M9 15h6" />
                            </svg><span v-if="!isLock">Groupes</span>
                        </inertia-link>
                    </div>
                    <div class="mt-6 pt-6">
                        <div class="px-2 space-y-1">

                        </div>
                    </div>
                </nav>
            </div>

            <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden h-screen lg:flex lg:flex-shrink-0" @mouseover="openWhenIsLock()"
            @mouseleave="closeWhenIsLock()">
            <div class="flex transition-all duration-500 flex-col w-auto">
                <div class="flex flex-col flex-grow overflow-y-auto">

                    <nav class="flex-1 flex flex-col divide-y divide-gray-600 overflow-y-auto" aria-label="Sidebar">
                        <div v-if="!isLock" class="w-32 ml-6 mr-8">
                            <img :src="baseUrl + '/img/logo4.png'" alt="" class="w-full">
                        </div>
                        <div v-else class="w-12">
                            <img :src="baseUrl + '/img/logo5.png'" alt="" class="w-full">
                        </div>
                        <div class="pt-6 bg-gray-600 h-full">

                            <div class="space-y-1 space-y-1 pt-5">

                                <inertia-link v-show="$page.props.user.is_admin"
                                    :class="isUrl('users') ? 'bg-gray-800 text-white group flex items-center px-2 py-2 text-sm leading-6 font-medium' : 'group flex items-center px-2 py-2 text-sm leading-6 font-medium text-white hover:text-white hover:bg-gray-700'"
                                    :href="route('users.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    <span v-if="!isLock">Utilisateurs</span>
                                </inertia-link>

                                <inertia-link
                                    :class="isUrl('documents') ? 'bg-gray-800 text-white group flex items-center px-2 py-2 text-sm leading-6 font-medium' : 'group flex items-center px-2 py-2 text-sm leading-6 font-medium text-white hover:text-white hover:bg-gray-700'"
                                    :href="route('documents.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6 text-white" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                        <path d="M14 3v5h5M16 13H8M16 17H8M10 9H8" />
                                    </svg>
                                    <span v-if="!isLock">Documents</span>
                                </inertia-link>

                                <inertia-link
                                    :class="isUrl('document_partagés') ? 'bg-gray-800 text-white group flex items-center px-2 py-2 text-sm leading-6 font-medium' : 'group flex items-center px-2 py-2 text-sm leading-6 font-medium text-white hover:text-white hover:bg-gray-700'"
                                    :href="route('document_share.index')">
                                    <svg class="mr-2 text-white" style="margin-left: -5px;" width="35px" height="35px"
                                        version="1.1" viewBox="0 0 700 700" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g>
                                            <path fill="#fff"
                                                d="m211.15 228.83h189c4.6367 0 8.3984-3.7578 8.3984-8.3984s-3.7617-8.3984-8.3984-8.3984h-189c-4.6406 0-8.3984 3.7578-8.3984 8.3984-0.003906 4.6406 3.7539 8.3984 8.3984 8.3984zm0-47.281h189c4.6367 0 8.3984-3.7578 8.3984-8.3984s-3.7617-8.3984-8.3984-8.3984h-189c-4.6406 0-8.3984 3.7578-8.3984 8.3984-0.003906 4.6406 3.7539 8.3984 8.3984 8.3984zm152.6 81.258c0-4.6406-3.7617-8.3984-8.3984-8.3984h-144.2c-4.6406 0-8.3984 3.7578-8.3984 8.3984s3.7578 8.3984 8.3984 8.3984h144.2c4.6367 0 8.3984-3.7578 8.3984-8.3984zm-70 33.98h-82.602c-4.6406 0-8.3984 3.7617-8.3984 8.3984s3.7578 8.3984 8.3984 8.3984h82.602c4.6406 0 8.3984-3.7617 8.3984-8.3984 0.003907-4.6367-3.7539-8.3984-8.3984-8.3984zm-27.734 42.371h-54.863c-4.6406 0-8.3984 3.7617-8.3984 8.3984 0 4.6367 3.7578 8.3984 8.3984 8.3984h54.863c4.6406 0 8.3984-3.7617 8.3984-8.3984 0-4.6367-3.7578-8.3984-8.3984-8.3984zm184.56 23.199c13.547 0 24.566-11.027 24.566-24.578s-11.02-24.578-24.566-24.578c-13.551 0-24.578 11.027-24.578 24.578 0 1.2891 0.18359 2.5273 0.375 3.7617l-45.383 33.074c-4.1758-3.2812-9.375-5.3242-15.086-5.3242-13.547 0-24.566 11.027-24.566 24.578 0 13.551 11.02 24.566 24.566 24.566 5.7188 0 10.914-2.0312 15.094-5.3242l45.516 33.105c-0.33594 1.6172-0.51953 3.293-0.51953 5.0117 0 13.551 11.027 24.578 24.578 24.578 13.547 0 24.566-11.027 24.566-24.578s-11.02-24.578-24.566-24.578c-5.7109 0-10.902 2.043-15.082 5.3242l-45.523-33.105c0.33594-1.6172 0.51562-3.2812 0.51562-5s-0.17969-3.3867-0.51953-5.0117l44.656-32.543c4.3125 3.7148 9.8398 6.043 15.957 6.043zm0-32.352c4.2852 0 7.7656 3.4883 7.7656 7.7773 0 4.2891-3.4844 7.7773-7.7656 7.7773-4.2891 0-7.7773-3.4883-7.7773-7.7773 0-4.2891 3.4883-7.7773 7.7773-7.7773zm-84.664 71.629c-4.2852 0-7.7656-3.4766-7.7656-7.7656 0-4.2891 3.4844-7.7773 7.7656-7.7773 4.2891 0 7.7773 3.4883 7.7773 7.7773 0 4.2891-3.4922 7.7656-7.7773 7.7656zm84.664 41.816c4.2852 0 7.7656 3.4883 7.7656 7.7773 0 4.2891-3.4844 7.7773-7.7656 7.7773-4.2891 0-7.7773-3.4883-7.7773-7.7773 0-4.2891 3.4883-7.7773 7.7773-7.7773zm3.0156-162.54v-144.7c0-2.2188-0.875-4.3398-2.4375-5.9141l-78.871-79.57c-1.5781-1.5898-3.7227-2.4883-5.9648-2.4883h-200.21c-4.6406 0-8.3984 3.7578-8.3984 8.3984v385.04c0 4.6367 3.7578 8.3984 8.3984 8.3984h155.73c19.836 36.695 58.656 61.68 103.21 61.68 64.652 0 117.25-52.602 117.25-117.25 0.003907-54.781-37.824-100.79-88.699-113.58zm-139.07 152.36h-140.02v-368.23h183.41v71.164c0 4.6406 3.7617 8.3984 8.3984 8.3984h70.469v133.24c-3.8594-0.38672-7.7773-0.59375-11.742-0.59375-64.652 0-117.25 52.594-117.25 117.25 0.007813 13.609 2.457 26.613 6.7344 38.777zm110.52 61.68c-55.391 0-100.45-45.062-100.45-100.45s45.066-100.45 100.45-100.45c55.383 0 100.45 45.062 100.45 100.45 0 55.391-45.059 100.45-100.45 100.45z" />
                                            <use x="70" y="644" xlink:href="#u" />
                                            <use x="90.550781" y="644" xlink:href="#c" />
                                            <use x="104.359375" y="644" xlink:href="#a" />
                                            <use x="123.347656" y="644" xlink:href="#i" />
                                            <use x="142.242188" y="644" xlink:href="#b" />
                                            <use x="155.628906" y="644" xlink:href="#a" />
                                            <use x="174.617188" y="644" xlink:href="#h" />
                                            <use x="204.410156" y="644" xlink:href="#g" />
                                            <use x="224.453125" y="644" xlink:href="#f" />
                                            <use x="252.453125" y="644" xlink:href="#e" />
                                            <use x="275.695312" y="644" xlink:href="#a" />
                                            <use x="294.683594" y="644" xlink:href="#a" />
                                            <use x="313.671875" y="644" xlink:href="#t" />
                                            <use x="333.71875" y="644" xlink:href="#s" />
                                            <use x="70" y="672" xlink:href="#r" />
                                            <use x="82.183594" y="672" xlink:href="#c" />
                                            <use x="95.992188" y="672" xlink:href="#d" />
                                            <use x="115.226562" y="672" xlink:href="#q" />
                                            <use x="154.152344" y="672" xlink:href="#b" />
                                            <use x="167.535156" y="672" xlink:href="#p" />
                                            <use x="187.46875" y="672" xlink:href="#a" />
                                            <use x="216.207031" y="672" xlink:href="#o" />
                                            <use x="239.640625" y="672" xlink:href="#d" />
                                            <use x="258.878906" y="672" xlink:href="#n" />
                                            <use x="278.8125" y="672" xlink:href="#m" />
                                            <use x="308.492188" y="672" xlink:href="#l" />
                                            <use x="329.015625" y="672" xlink:href="#c" />
                                            <use x="342.820312" y="672" xlink:href="#d" />
                                            <use x="362.058594" y="672" xlink:href="#k" />
                                            <use x="371.65625" y="672" xlink:href="#a" />
                                            <use x="390.648438" y="672" xlink:href="#j" />
                                            <use x="407.242188" y="672" xlink:href="#b" />
                                        </g>
                                    </svg>
                                    <span v-if="!isLock">Documents Partagés</span>
                                </inertia-link>

                                <inertia-link
                                    :class="isUrl('groups') ? 'bg-gray-800 text-white group flex items-center px-2 py-2 text-sm leading-6 font-medium' : 'group flex items-center px-2 py-2 text-sm leading-6 font-medium text-white hover:text-white hover:bg-gray-700'"
                                    :href="route('groups.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 text-white h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span v-if="!isLock">Groupes</span>
                                </inertia-link>

                            </div>
                        </div>
                    </nav>
                    <div class="divide-y divide-white">
                        <button @click="lock()"
                            class="w-full inline-flex items-center px-2 py-2 border border-transparent text-xs font-medium shadow-sm text-white bg-gray-600 hover:bg-gray-800 focus:outline-none">
                            <svg v-if="lockSidebar" xmlns="http://www.w3.org/2000/svg" :class="!isLock ? 'mr-4' : ''"
                                class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <svg v-if="!lockSidebar" xmlns="http://www.w3.org/2000/svg" :class="!isLock ? 'mr-4' : ''"
                                class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 9.9-1"></path>
                            </svg>
                            <span v-if="!isLock">Menu verrouillage</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import DropdownMenu from '@/Shared/DropdownMenu'
export default {
    created() {
        this.baseUrl = window.location.origin
    },
    data() {
        return {
            baseUrl: null,
            isLock: false,
            lockSidebar: false
        }
    },
    props: {
        hiddeMenu: Boolean
    },
    computed: {

        width: {
            get() {
                return screen.width;
            }
        }
    },
    components: {
        DropdownMenu
    },
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1)

            if (urls[0] === '') {
                return currentUrl === ''
            }

            return urls.filter(url => currentUrl.startsWith(url)).length
        },
        toggleMenu() {
            //console.log('toogle sidebar');
            this.$emit('hidde')

        },
        lock() {
            if (this.lockSidebar) {
                this.isLock = false
                this.lockSidebar = false
            } else {
                this.isLock = true
                this.lockSidebar = true
            }
            this.$emit('lock', this.isLock)
        },
        openWhenIsLock() {
            if (this.lockSidebar) {
                this.isLock = false
            }
            this.$emit('lock', this.isLock)
        },
        closeWhenIsLock() {
            if (this.lockSidebar) {
                this.isLock = true
            }
            this.$emit('lock', this.isLock)
        }


    },
}
</script>