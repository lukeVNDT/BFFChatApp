<template>
  <div class="OtherProfile">
    <!-- BEGIN: Top Bar -->
    <div class="top-bar">
      <!-- BEGIN: Breadcrumb -->
      <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a>BFFChat </a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a class="breadcrumb--active">User profile</a>
      </div>
      <!-- END: Breadcrumb -->

      <!-- BEGIN: Account Menu -->
      <div class="intro-x dropdown w-8 h-8">
        <div
          class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in"
          role="button"
          aria-expanded="false"
        >
          <img
            v-if="currentuser.avatar != null"
            alt="Midone Tailwind HTML Admin Template"
            class="rounded-full"
            :src="
              'https://res.cloudinary.com/dtiazqxyd/image/upload/v1648964340/' +
              currentuser.avatar
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
            class="dropdown-menu__content box bg-theme-26 dark:bg-dark-6 text-white"
          >
            <div class="p-4 border-b border-theme-27 dark:border-dark-3">
              <div class="font-medium">{{ currentuser.displayName }}</div>
            </div>
            <div class="p-2">
              <router-link
                to="/profile"
                class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"
              >
                <i class="fas fa-user mr-2"></i> Profile
              </router-link>
              <router-link
                to="/"
                class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"
              >
                <i class="fab fa-rocketchat mr-2"></i> Return to Chats
              </router-link>
            </div>
            <div class="p-2 border-t border-theme-27 dark:border-dark-3">
              <a
                @click="logout"
                class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"
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
      <h2 class="text-lg font-medium mr-auto">User Profile</h2>
    </div>

    <div class="grid grid-cols-12 gap-6">
      <!-- BEGIN: Profile Menu -->
      <div
        class="col-span-12 lg:col-span-9 xxl:col-span-10 flex lg:block flex-col-reverse"
      >
        <div class="intro-y box lg:mt-5">
          <div
            class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5"
          >
            <h2 class="font-medium text-base mr-auto"></h2>
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
                      <h6 class="text-gray-600 font-medium leading-none mt-3">
                        {{ profile.displayName }}
                      </h6>
                    </div>
                  </div>
                  <div class="col-span-12 xxl:col-span-6">
                    <div class="mt-3">
                      <label for="update-profile-form-4" class="form-label"
                        >Phone Number</label
                      >
                      <h6 class="text-gray-600 font-medium leading-none mt-3">
                        {{ profile.phoneNumber }}
                      </h6>
                    </div>
                  </div>
                  <div class="col-span-12">
                    <div class="mt-3">
                      <label for="update-profile-form-5" class="form-label"
                        >Country</label
                      >
                      <h6 class="text-gray-600 font-medium leading-none mt-3">
                        {{ profile.country }}
                      </h6>
                    </div>
                  </div>
                  <div class="col-span-12">
                    <div class="mt-3">
                      <label for="update-profile-form-5" class="form-label"
                        >Address</label
                      >
                      <h6 class="text-gray-600 font-medium leading-none mt-3">
                        {{ profile.address }}
                      </h6>
                    </div>
                  </div>
                  <div class="col-span-12">
                    <div class="mt-3">
                      <label for="update-profile-form-5" class="form-label"
                        >Short Description</label
                      >
                      <h6 class="text-gray-600 font-medium leading-none mt-3">
                        {{ profile.shortDescription }}
                      </h6>
                    </div>
                  </div>
                </div>
              </div>
              <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                <div
                  class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5"
                >
                  <div
                    class="h-40 relative image-fit cursor-pointer zoom-in mx-auto"
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
            class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5"
          >
            <h2 class="font-medium text-base mr-auto">Action</h2>
          </div>
          <div class="p-5">
            <div class="flex flex-col-reverse xl:flex-row flex-col">
              <div class="flex-1 mt-6 xl:mt-0">
                <button
                  v-if="friendCheck != ''"
                  @click="removeFriend"
                  type="button"
                  class="btn btn-primary w-22 mt-1"
                >
                  <i
                    v-if="loading"
                    class="fas fa-circle-notch fa-spin mr-1"
                  ></i>
                  <i v-else class="fas fa-user-minus mr-1"></i>
                  Unfriend
                </button>
                <button
                  id="btn-add-friend"
                  v-else
                  type="button"
                  class="btn btn-primary w-20 mt-1"
                  @click="invitefriend"
                >
                  <i
                    v-if="loading"
                    class="fas fa-circle-notch fa-spin mr-1"
                  ></i>
                  <i v-else class="fas fa-user-plus mr-1"></i>
                  Add
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- END: Display Information -->
      </div>
    </div>
  </div>
</template>

<script>
const notyf = new Notyf();
export default {
  data() {
    return {
      profile: {},
      currentuser: {},
      friendCheck: [],
      loading: false,
      email: "",
    };
  },
  created() {
    this.getUserProfile();
    this.getotherprofile();
  },
  methods: {
    invitefriend() {
      const data = {
        email: this.email,
      };

      this.loading = !this.loading;

      setTimeout(() => {
        axios
          .post("/sendfriendrequest", data)
          .then((res) => {
            console.log(res);
            if (res.data.error) {
              this.loading = !this.loading;
              Toast.fire({
                icon: "error",
                title: res.data.error,
              });
            } else if (res.data.selferror) {
              this.loading = !this.loading;
              Toast.fire({
                icon: "error",
                title: res.data.selferror,
              });
            } else if (res.data.exist) {
              this.loading = !this.loading;
              Toast.fire({
                icon: "warning",
                title: res.data.exist,
              });
            } else if (res.data.waiting) {
              this.loading = !this.loading;
               notyf
                .error({
                  message: res.data.waiting,
                  duration: 3000,
                  position: {
                    x: "right",
                    y: "top",
                  },
                  dismissible: true,
                })
                .on("dismiss", ({ target, event }) => foobar.retry());
            } else {
              this.loading = !this.loading;
              notyf
                .success({
                  message: res.data.status,
                  duration: 3000,
                  position: {
                    x: "right",
                    y: "top",
                  },
                  dismissible: true,
                })
                .on("dismiss", ({ target, event }) => foobar.retry());
            }
          })
          .catch((err) => {
            console.log(err);
          });
      }, 2000);
    },
    getUserProfile() {
      axios
        .get("/getuserprofile")
        .then((res) => {
          this.currentuser = res.data.currentUser[0];
        })
        .catch((err) => {
          Toast.fire({
            icon: "error",
            title: "Opps! something went wrong",
          });
        });
    },
    removeFriend() {
      let id = this.$route.params.id;
      this.loading = !this.loading;
      setTimeout(()=>{
        axios
        .delete(`/delete-friend/${id}`)
        .then((res) => {
           notyf
                .success({
                  message: 'Unfriend successfully',
                  duration: 3000,
                  position: {
                    x: "right",
                    y: "top",
                  },
                  dismissible: true,
                })
                .on("dismiss", ({ target, event }) => foobar.retry());
          this.$router.push("/");
        })
        .catch((err) => {
          console.log(err);
        });
      },2000);
      
    },
    logout() {
      axios
        .get("/logout")
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "Logout successfully!",
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getotherprofile() {
      axios
        .get("/getotherprofile/" + this.$route.params.id)
        .then((res) => {
          this.profile = res.data.profile[0];
          this.friendCheck = res.data.friendCheck;
          this.email = res.data.profile[0].email;
          console.log(this.profile);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style scoped>
.line {
  display: inline-block !important;
  white-space: nowrap !important;
}
.box {
  border-radius: 20px;
}
.btn-primary {
  background-color: #e3175b !important;
  border-color: #e3175b !important;
  color: #fff;
}
#btn-add-friend {
  background-color: #766ac8 !important;
  border-color: #766ac8 !important;
}
</style>