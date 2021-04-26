<template>
  <div class="left-bar">
    
    <div class="menu">
      <p class="title">Nhân viên</p>
      <div class="dropdown">
        <ul>
          <li><router-link to="/user/list">Danh sách</router-link></li>
          <li><router-link to="/user/create">Thêm mới</router-link></li>
        </ul>
      </div>
    </div>

    <div class="menu">
      <p class="title">Phòng ban</p>
      <div class="dropdown">
        <ul>
          <li><router-link to="/department/list">Danh sách</router-link></li>
          <li><router-link to="/department/create">Thêm mới</router-link></li>
        </ul>
      </div>
    </div>

    <div class="menu">
      <p class="title"><router-link to="/check-in">Lịch làm việc</router-link></p>
    </div>
    
    <div class="menu">
      <p class="title">Yêu cầu</p>
      <div class="dropdown">
        <ul>
          <li><router-link to="/request/list">Yêu cầu của tôi</router-link></li>
          <li><router-link to="/request/create">Tạo yêu cầu</router-link></li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {

}
</script>

<style lang="scss">
.left-bar {
  background-color: #2d90ca;
  height: calc(100vh - 56px);
  padding: 10px;
  overflow-y: auto;
}
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
    padding-bottom: 5px;
    border-bottom: 1px solid #e3e3e3;
  }
  .dropdown {
    ul {
      list-style-type: none;
      margin-bottom: 0;
      li {
        padding: 5px 10px;
        cursor: pointer;
        &:hover {
          background-color: lightgrey;
        }
      }
    }
  }
}
</style>