<script setup>
import SideNav from './shared/DashboardSideNav.vue'
import NavigationBar from './shared/DashboardNavigationBar.vue'
import Footer from './shared/DashboardFooter.vue'
</script>
<template>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
       <SideNav></SideNav>
        <div class="layout-page">
          <NavigationBar></NavigationBar>
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <slot></slot>
            </div>
           <Footer></Footer>
            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
</template>
