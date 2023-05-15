<script setup>
import {Link} from '@inertiajs/vue3'
import { computed } from 'vue'

const  props = defineProps({
    links: {
        type:Array,
        required:true
     },
     firstPageUrl:{
        type:String,
        required:true
     },
     lastPageUrl:{
        type:String,
        required:true
     },
     lastpageCheck:{
        type:Number,
        required:true
     }
});

const checkingPageCount = computed(() => {
  return props.lastpageCheck > 1 ? true : false
})

</script>

<template>
  <div class="row">
        <div class="col d-flex justify-content-center">
            <div class="demo-inline-spacing">
            <!-- Basic Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li v-if="checkingPageCount" class="page-item first">
                        <Link class="page-link" :href="firstPageUrl"><i class="tf-icon bx bx-chevrons-left"></i></Link>
                    </li>
                    <li v-for="(link,index) in links" class="page-item" :class="{ 'active': link.active }">
                        <Link v-if="link.url!=null" class="page-link"  :href="link.url" v-html="link.label"></Link>
                    </li>
                    <li v-if="checkingPageCount" class="page-item last">
                        <Link class="page-link" :href="lastPageUrl"><i class="tf-icon bx bx-chevrons-right"></i></Link>
                    </li>
                </ul>
            </nav>
            <!--/ Basic Pagination -->
            </div>
        </div>
    </div>
</template>



