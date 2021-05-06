<template>
  <div class="menu">
    <p class="title" 
      :class="{'has-child': router.children && router.children.length > 0}"
      v-if="router.children && router.children.length > 0"
      @click="toggleDropdown"
    >
      <span>{{ router.title }}</span>
      <font-awesome-icon class="icon" 
        :class="{'active': isShow}"
        icon="angle-up"/>
    </p>
    <p class="title" v-else><router-link :to="router.link" active-class="active"><span>{{ router.title }}</span></router-link></p>
    <div class="dropdown" :class="{'active': isShow}" v-if="router.children && router.children.length > 0" v-show="isShow">
      <ul>
        <li v-for="child of router.children" :key="child.id">
          <router-link :to="child.link" active-class="active">{{ child.title }}</router-link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'menu-dropdown',
  props: {
    router: {
      type: Object
    }
  },
  data () {
    return {
      isShow: true
    };
  },
  methods: {
    toggleDropdown () {
      this.isShow = !this.isShow;
    }
  }
}
</script>

<style lang="scss">
.menu {
  background-color: white;
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 10px;

  .title {
    font-size: 15px;
    font-weight: bold;
    margin-left: 5px;
    margin-bottom: 0px;
    cursor: pointer;
    
    &.has-child {
      padding-bottom: 5px;
      border-bottom: 1px solid #e3e3e3;
    }
    display: flex;
    justify-content: space-between;
    align-items: center;
    .icon {
      transition: 0.4s;
      &.active {
        transform: rotate(-180deg);
      }
    }
    a {
      text-decoration: none;
      color: #131314;

      &.active {
        color: #2d90ca!important;
      }
    }
  }
  .dropdown {
    transition: 0.4s;
    height: 0px;
    overflow: hidden;
    &.active {
      height: 100%;
    }
    ul {
      list-style-type: none;
      margin-bottom: 0;
      li {
        padding: 5px 10px;
        cursor: pointer;
        &:hover {
          background-color: lightgrey;
        }
        a {
          text-decoration: none;
          color: #131314;

          &.active {
            color: #2d90ca;
            font-weight: bold;
          }
        }
      }
    }
  }
}
</style>