<template>
  <div class="upload-avatar">
    <p class="mb-2">Ảnh đại diện</p>
    <img 
      class="image-preview mb-3" 
      :src="value" 
      :alt="value"
    />
    <div class="input-upload">
      <input 
        type="file" 
        name="input-avatar" 
        class="input-hidden"
        ref="inputAvatar"
        accept="image/*"
        @change="onSelectedFile"
      >
      <b-button variant="success" @click="onSelectFile">Tải lên</b-button>
    </div>
  </div>
</template>

<script>
import { storeFile } from '../apis/storage';

export default {
  name: 'avatar',
  props: {
    value: {
      type: String,
      default: 'https://via.placeholder.com/150'
    },
    onChange: {
      type: Function,
      require: true
    }
  },
  methods: {
    onSelectFile () {
      this.$refs.inputAvatar.click();
    },
    async onSelectedFile (event) {
      const files = event.target.files;
      let {url} = await storeFile(files[0]);
      this.onChange(url);
    },
  }
}
</script>

<style lang="scss">
.upload-avatar {
  text-align: center;
  img {
    max-width: 150px;
    max-height: 150px;
  }
  p {
    margin-bottom: 10px;
  }
  .image-preview {
    max-width: 200px;
    max-height: 200px;
  }
  .input-upload {
    .input-hidden {
      display: none;
    }
  }
}
</style>