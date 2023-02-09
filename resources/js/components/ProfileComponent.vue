<template>
  <div class="Profile">
    <!-- BEGIN: Top Bar -->
    <div class="top-bar">
      <!-- BEGIN: Breadcrumb -->
      <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a>BFFChat</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a class="breadcrumb--active">Your Profile</a>
      </div>
      <!-- END: Breadcrumb -->

      <!-- BEGIN: Account Menu -->
      <div class="intro-x dropdown w-8 h-8">
        <div
          class="
            dropdown-toggle
            w-8
            h-8
            rounded-full
            overflow-hidden
            shadow-lg
            image-fit
            zoom-in
          "
          role="button"
          aria-expanded="false"
        >
          <img
            v-if="profile.avatar != null"
            alt="Midone Tailwind HTML Admin Template"
            class="rounded-full"
            :src="
              'https://res.cloudinary.com/dtiazqxyd/image/upload/v1648964340/' +
              profile.avatar
            "
          />
          <img
            v-else
            alt="Avatar"
            class="rounded-full"
            :src="'../dist2/images/avatardefault_92824-removebg.png'"
          />
        </div>
        <div class="dropdown-menu w-56">
          <div
            class="
              dropdown-menu__content
              box
              bg-theme-26
              dark:bg-dark-6
              text-white
            "
          >
            <div class="p-4 border-b border-theme-27 dark:border-dark-3">
              <div class="font-medium">{{ profile.displayName }}</div>
            </div>
            <div class="p-2">
              <router-link
                to="/profile"
                class="
                  flex
                  items-center
                  block
                  p-2
                  transition
                  duration-300
                  ease-in-out
                  hover:bg-theme-1
                  dark:hover:bg-dark-3
                  rounded-md
                "
              >
                <i class="fas fa-user mr-2"></i> Profile
              </router-link>
              <router-link
                to="/"
                class="
                  flex
                  items-center
                  block
                  p-2
                  transition
                  duration-300
                  ease-in-out
                  hover:bg-theme-1
                  dark:hover:bg-dark-3
                  rounded-md
                "
              >
                <i class="fab fa-rocketchat mr-2"></i> Return to Chats
              </router-link>
            </div>
            <div class="p-2 border-t border-theme-27 dark:border-dark-3">
              <a
                @click="logout"
                class="
                  flex
                  items-center
                  block
                  p-2
                  transition
                  duration-300
                  ease-in-out
                  hover:bg-theme-1
                  dark:hover:bg-dark-3
                  rounded-md
                "
              >
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- END: Account Menu -->
    </div>
    <!-- END: Top Bar -->
    <div class="intro-y flex items-center mt-8">
      <h2 class="text-lg font-medium mr-auto">Update Profile</h2>
    </div>
    <form v-on:submit.prevent="saveProfile">
      <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Profile Menu -->
        <div
          class="
            col-span-12
            lg:col-span-9
            xxl:col-span-10
            flex
            lg:block
            flex-col-reverse
          "
        >
          <div class="intro-y box lg:mt-5">
            <div
              class="
                flex
                items-center
                p-5
                border-b border-gray-200
                dark:border-dark-5
              "
            >
              <h2 class="font-medium text-base mr-auto">Display Information</h2>
            </div>
            <div class="p-5">
              <div class="flex flex-col-reverse xl:flex-row flex-col">
                <div class="flex-1 mt-6 xl:mt-0">
                  <div class="grid grid-cols-12 gap-x-5">
                    <div class="col-span-12 xxl:col-span-6">
                      <div>
                        <label for="update-profile-form-1" class="form-label"
                          >Display Name</label
                        >
                        <input
                          v-model="profile.displayName"
                          id="update-profile-form-1"
                          type="text"
                          class="form-control"
                          placeholder="Display Name"
                        />
                      </div>
                    </div>
                    <div class="col-span-12 xxl:col-span-6">
                      <div>
                        <label for="update-profile-form-4" class="form-label"
                          >Phone Number</label
                        >
                        <input
                          v-model="profile.phoneNumber"
                          id="update-profile-form-4"
                          type="text"
                          class="form-control"
                          placeholder="Phone Number"
                        />
                      </div>
                    </div>
                    <div class="col-span-12">
                      <div class="mt-3">
                        <label for="update-profile-form-5" class="form-label"
                          >Country</label
                        >
                        <input
                          v-model="profile.country"
                          id="update-profile-form-4"
                          type="text"
                          class="form-control"
                          placeholder="Your Country"
                        />
                      </div>
                    </div>
                    <div class="col-span-12">
                      <div class="mt-3">
                        <label for="update-profile-form-5" class="form-label"
                          >Address</label
                        >
                        <textarea
                          v-model="profile.address"
                          id="update-profile-form-5"
                          class="form-control"
                          placeholder="Address"
                        ></textarea>
                      </div>
                    </div>
                    <div class="col-span-12">
                      <div class="mt-3">
                        <label for="update-profile-form-5" class="form-label"
                          >Short Description</label
                        >
                        <textarea
                          v-model="profile.shortDescription"
                          rows="4"
                          id="update-profile-form-5"
                          class="form-control"
                          placeholder="Short Description"
                        ></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                  <div
                    class="
                      border-2 border-dashed
                      shadow-sm
                      border-gray-200
                      dark:border-dark-5
                      rounded-md
                      p-5
                    "
                  >
                    <div
                      class="
                        h-40
                        relative
                        image-fit
                        cursor-pointer
                        zoom-in
                        mx-auto
                      "
                    >
                      <img
                        id="uploadedAvatar"
                        v-if="profile.avatar != null"
                        alt="Midone Tailwind HTML Admin Template"
                        class="rounded-full"
                        :src="
                          'https://res.cloudinary.com/dtiazqxyd/image/upload/v1648964340/' +
                          profile.avatar
                        "
                      />
                      <img
                        id="uploadedAvatar"
                        v-else
                        alt="Avatar"
                        class="rounded-full"
                        :src="'../dist2/images/avatardefault_92824-removebg.png'"
                      />
                    </div>
                    <div class="mx-auto cursor-pointer relative mt-5">
                      <button type="button" class="btn btn-primary w-full">
                        Change Photo
                      </button>
                      <input
                        @change="uploadAndReset"
                        type="file"
                        class="w-full h-full top-0 left-0 absolute opacity-0"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END: Profile Menu -->
        <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
          <!-- BEGIN: Display Information -->
          <div class="intro-y box lg:mt-5">
            <div
              class="
                flex
                items-center
                p-5
                border-b border-gray-200
                dark:border-dark-5
              "
            >
              <h2 class="font-medium text-base mr-auto">Action</h2>
            </div>
            <div class="p-5">
              <div class="flex flex-col-reverse xl:flex-row flex-col">
                <div class="flex-1 mt-6 xl:mt-0">
                  <button type="submit" class="btn btn-primary w-20 mt-1">
                    <i
                      v-if="loading"
                      class="fas fa-circle-notch fa-spin mr-1"
                    ></i>
                    Save
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- END: Display Information -->
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      profile: [],
      avatar: "",
      loading: false,
    };
  },
  created() {
    this.getUserProfile();
  },
  methods: {
    getUserProfile() {
      axios
        .get("/getuserprofile")
        .then((res) => {
          this.profile = res.data.user[0];
          console.log(res.data);
        })
        .catch((err) => {
          Toast.fire({
            icon: "error",
            title: "Opps! something went wrong",
          });
        });
    },
    uploadAndReset(e) {
      // Update/reset user image of account page
      let accountUserImage = document.getElementById("uploadedAvatar");
      if (e.target.files[0]) {
        accountUserImage.src = window.URL.createObjectURL(e.target.files[0]);
        this.avatar = e.target.files[0];
        console.log(this.avatar);
      }
    },
    saveProfile() {
      if (this.profile.displayName == "") {
        Toast.fire({
          icon: "error",
          title: "This field can not empty! Please fill your Display name",
        });
      } else {
        let form = new FormData();

        form.append("displayName", this.profile.displayName);
        form.append("phoneNumber", this.profile.phoneNumber);
        form.append("address", this.profile.address);
        form.append("country", this.profile.country);
        form.append("shortDescription", this.profile.shortDescription);
        form.append("avatar", this.avatar);
        this.loading = !this.loading;
        setTimeout(() => {
          axios
            .post("/save-profile", form)
            .then((res) => {
              this.loading = !this.loading;
              Toast.fire({
                icon: "success",
                title: "Profile saved successfully!",
              });
            })
            .catch((err) => {
              Toast.fire({
                icon: "error",
                title: "Opps! something went wrong",
              });
            });
        }, 2000);
      }
    },
    logout() {
      axios
        .get("/logout")
        .then((res) => {
          window.location.reload();
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style scoped>
.btn-primary {
  background-color: rgb(82, 78, 238) !important;
}
.box {
  border-radius: 20px !important;
}
</style>