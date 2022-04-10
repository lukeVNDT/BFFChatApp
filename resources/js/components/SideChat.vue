<template>
  <div class="SideChat">
    <!-- BEGIN: Top Bar -->
    <div class="top-bar">
      <!-- BEGIN: Breadcrumb -->
      <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a>BFFChat</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a class="breadcrumb--active">Chat</a>
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
            class="
              dropdown-menu__content
              box
              bg-theme-26
              dark:bg-dark-6
              text-white
            "
          >
            <div class="p-4 border-b border-theme-27 dark:border-dark-3">
              <div class="font-medium">{{ currentuser.displayName }}</div>
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
                <i class="fas fa-user mr-2"></i>Update Profile
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
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
      <h2 class="text-lg font-medium mr-auto">Chat</h2>
    </div>
    <div class="intro-y chat grid grid-cols-12 gap-5 mt-5">
      <!-- BEGIN: Chat Side Menu -->
      <div class="col-span-12 lg:col-span-4 xxl:col-span-3">
        <div class="intro-y pr-1">
          <div class="box p-2">
            <div class="chat__tabs nav nav-tabs justify-center" role="tablist">
              <a
                id="chats-tab"
                data-toggle="tab"
                data-target="#chats"
                href="javascript:;"
                class="flex-1 py-2 rounded-md text-center active"
                role="tab"
                aria-controls="chats"
                aria-selected="true"
                ><i class="fas fa-comment-dots mr-1"></i>Chats</a
              >
              <a
                id="friends-tab"
                data-toggle="tab"
                data-target="#friends"
                href="javascript:;"
                class="flex-1 py-2 rounded-md text-center"
                role="tab"
                aria-controls="friends"
                aria-selected="false"
                ><i class="fas fa-user-friends mr-1"></i>Friends</a
              >
              <a
                id="profile-tab"
                data-toggle="tab"
                data-target="#profile"
                href="javascript:;"
                class="flex-1 py-2 rounded-md text-center"
                role="tab"
                aria-controls="profile"
                aria-selected="false"
                ><i class="fas fa-bell mr-1"></i>Notification</a
              >
            </div>
          </div>
        </div>
        <div class="tab-content">
          <div
            id="chats"
            class="tab-pane active"
            role="tabpanel"
            aria-labelledby="chats-tab"
          >
            <div class="pr-1">
              <div class="box px-5 pt-5 pb-5 lg:pb-0 mt-5">
                <div class="relative text-gray-700 dark:text-gray-300">
                  <input
                    v-model="keywords"
                    type="text"
                    class="
                      form-control
                      py-3
                      px-4
                      border-transparent
                      bg-gray-200
                      pr-10
                      placeholder-theme-13
                    "
                    placeholder="Search for users..."
                  />
                  <i
                    class="
                      w-4
                      h-4
                      hidden
                      sm:absolute
                      my-auto
                      inset-y-0
                      mr-3
                      right-0
                    "
                    data-feather="search"
                  ></i>
                </div>
                <div class="overflow-x-auto scrollbar-hidden">
                  <div class="flex mt-5"></div>
                </div>
              </div>
            </div>

            <div class="parent__loop">
              <div
                class="
                  chat__chat-list
                  overflow-y-auto
                  scrollbar-hidden
                  pr-1
                  pt-1
                  mt-4
                "
              >
                <div
                  v-for="person in users"
                  :key="person.id"
                  class="chatloop"
                  @click="activeuser = person.user_id"
                >
                  <div
                    v-if="currentuser.id != person.user_id"
                    :class="activeuser == person.user_id ? 'active' : ''"
                    style="border-radius: 5px !important"
                    class="
                      intro-x
                      cursor-pointer
                      box
                      relative
                      flex
                      items-center
                      p-5
                      mt-3
                    "
                  >
                    <div class="w-12 h-12 flex-none image-fit mr-1">
                      <img
                        v-if="person.avatar != null"
                        alt="Midone Tailwind HTML Admin Template"
                        class="rounded-full"
                        :src="
                          'https://res.cloudinary.com/dtiazqxyd/image/upload/v1648964340/' +
                          person.avatar
                        "
                      />
                      <img
                        v-else
                        alt="Avatar"
                        class="rounded-full"
                        :src="'../dist2/images/avatardefault_92824-removebg.png'"
                      />
                      <div
                        :class="
                          onlineuser.find(
                            (onlineusers) => onlineusers.id === person.user_id
                          )
                            ? 'w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white'
                            : 'w-3 h-3 bg-theme-6 absolute right-0 bottom-0 rounded-full border-2 border-white'
                        "
                      ></div>
                    </div>
                    <div class="ml-2 overflow-hidden">
                      <div class="flex items-center">
                        <a href="javascript:;" class="font-medium">{{
                          person.name
                        }}</a>
                      </div>
                      <div class="mt-1 text-xs text-theme-21">
                        User
                        {{
                          onlineuser.find(
                            (onlineusers) =>
                              onlineusers.id === userchoose.user_id
                          )
                            ? "Online"
                            : "Offline"
                        }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- <div v-else class="chat__chat-list overflow-y-auto scrollbar-hidden pr-1 pt-1 mt-4">
									<div class="chatloop" >
                                    <div style="border-left: 6px solid #fcca00; border-radius: 5px !important" class="intro-x cursor-pointer box relative flex items-center p-5 mt-3">
                                        <i style="color: #fcca00" class="fas fa-exclamation-triangle fa-lg"></i>
                                        <div class="ml-2 overflow-hidden">
                                            <div class="flex items-center">
                                                <a  href="javascript:;" class="font-medium">you don't have friends yet, make friends to have interesting conversations</a>  
                                            </div>
                                           
                                        </div>
										
									</div>
								    </div>
                                </div> -->
            </div>
          </div>
          <div
            id="friends"
            class="tab-pane"
            role="tabpanel"
            aria-labelledby="friends-tab"
          >
            <form v-on:submit.prevent="invitefriend">
              <div class="pr-1">
                <div class="box p-5 mt-5">
                  <div class="relative text-gray-700 dark:text-gray-300">
                    <input
                      v-model="friendemail"
                      type="text"
                      class="
                        form-control
                        py-3
                        px-4
                        border-transparent
                        bg-gray-200
                        pr-10
                        placeholder-theme-13
                      "
                      placeholder="Enter user's email"
                    />
                    <i
                      class="
                        w-4
                        h-4
                        hidden
                        sm:absolute
                        my-auto
                        inset-y-0
                        mr-3
                        right-0
                      "
                      data-feather="search"
                    ></i>
                  </div>
                  <button
                    style="background-color: #524eee !important"
                    type="submit"
                    class="btn btn-primary mt-3"
                  >
                    <i
                      v-if="loading"
                      class="fas fa-circle-notch fa-spin mr-1"
                    ></i>
                    <i v-else class="fas fa-user-plus mr-1"></i>
                    Invite Friend
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div
            id="profile"
            class="tab-pane"
            role="tabpanel"
            aria-labelledby="profile-tab"
          >
            <div
              class="chat__user-list overflow-y-auto scrollbar-hidden pr-1 pt-1"
            >
              <div class="mt-4 text-gray-600">Notification</div>
              <div
                style="
                  border-left: 6px solid #02de6b;
                  border-radius: 5px !important;
                "
                v-for="(noti, index) in notify"
                :key="noti.id"
                class="cursor-pointer box relative flex items-center p-5 mt-5"
              >
                <div class="ml-2 overflow-hidden">
                  <div class="flex items-center">
                    <a href="" class="font-medium"
                      >{{ noti.user.name }} {{ noti.content }}</a
                    >
                  </div>
                </div>
                <div class="dropdown ml-auto">
                  <a
                    class="dropdown-toggle w-5 h-5 block"
                    href="javascript:;"
                    aria-expanded="false"
                  >
                    <i class="fas fa-ellipsis-v"></i
                  ></a>
                  <div class="dropdown-menu w-40">
                    <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                      <a
                        @click="acceptRequest(noti, index)"
                        class="
                          flex
                          items-center
                          block
                          p-2
                          transition
                          duration-300
                          ease-in-out
                          bg-white
                          dark:bg-dark-1
                          hover:bg-gray-200
                          dark:hover:bg-dark-2
                          rounded-md
                        "
                      >
                        <i data-feather="share-2" class="w-4 h-4 mr-2"></i>
                        Accept
                      </a>
                      <a
                        @click="removeRequest(noti.id,noti.user_id, index)"
                        class="
                          flex
                          items-center
                          block
                          p-2
                          transition
                          duration-300
                          ease-in-out
                          bg-white
                          dark:bg-dark-1
                          hover:bg-gray-200
                          dark:hover:bg-dark-2
                          rounded-md
                        "
                      >
                        <i data-feather="copy" class="w-4 h-4 mr-2"></i> Remove
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div v-else id="profile" class="tab-pane" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="pr-1">
                                    <div class="box px-5 py-10 mt-5">
                                        <div class="w-20 h-20 flex-none image-fit rounded-full overflow-hidden mx-auto">
                                            <img alt="Avatar" >
                                        </div>
                                        <div class="text-center mt-3">
                                            <div class="font-medium text-lg"></div>
                                             <div class="text-gray-600 mt-1"></div>
                                        </div>
                                    </div>
                                    <div class="box p-5 mt-5">
                                        <div class="flex items-center border-b border-gray-200 dark:border-dark-5 py-5">
                                            <div>
                                                <div class="text-gray-600">Phone</div>
                                                <div class="mt-1"></div>
                                            </div>
                                            <i data-feather="mic" class="w-4 h-4 text-gray-600 ml-auto"></i> 
                                        </div>
                                         <div class="flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                                            <div>
                                                <div class="text-gray-600">Country</div>
                                                <div class="mt-1"></div>
                                            </div>
                                            <i data-feather="globe" class="w-4 h-4 text-gray-600 ml-auto"></i> 
                                        </div>
                                        <div class="flex items-center border-b border-gray-200 dark:border-dark-5 py-5">
                                            <div>
                                                <div class="text-gray-600">Address</div>
                                                <div class="mt-1"></div>
                                            </div>
                                            <i data-feather="mail" class="w-4 h-4 text-gray-600 ml-auto"></i> 
                                        </div>
                                       
                                    </div>
                                </div>
                            </div> -->
        </div>
      </div>
      <!-- END: Chat Side Menu -->

      <!-- BEGIN: Chat Content -->
      <div class="intro-y col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="chat__box box">
          <!-- BEGIN: Chat Active -->

          <div v-if="activeuser != null" class="h-full flex flex-col">
            <div
              class="
                flex flex-col
                sm:flex-row
                border-b border-gray-200
                dark:border-dark-5
                px-5
                py-4
              "
            >
              <div class="flex items-center">
                <div
                  class="w-10 h-10 sm:w-12 sm:h-12 flex-none image-fit relative"
                >
                  <img
                    v-if="userchoose.avatar != null"
                    alt="Midone Tailwind HTML Admin Template"
                    class="rounded-full"
                    :src="
                      'https://res.cloudinary.com/dtiazqxyd/image/upload/v1648964340/' +
                      userchoose.avatar
                    "
                  />
                  <img
                    v-else
                    alt="Avatar"
                    class="rounded-full"
                    :src="'../dist2/images/avatardefault_92824-removebg.png'"
                  />
                </div>
                <div class="ml-3 mr-auto">
                  <div class="font-medium text-base">
                    {{ userchoose.displayName }}
                  </div>
                  <div v-if="userchoose.shortDescription != null" class="text-gray-600 text-xs sm:text-sm">
                    {{ userchoose.shortDescription.substring(0, 40) + "..." }}
                    <span class="mx-1">•</span>
                    {{
                      onlineuser.find(
                        (onlineusers) => onlineusers.id === userchoose.user_id
                      )
                        ? "Online"
                        : "Offline"
                    }}
                  </div>
                  <div v-else class="text-gray-600 text-xs sm:text-sm">
                    Some quotes...
                    <span class="mx-1">•</span>
                    {{
                      onlineuser.find(
                        (onlineusers) => onlineusers.id === userchoose.user_id
                      )
                        ? "Online"
                        : "Offline"
                    }}
                  </div>
                </div>
              </div>
              <div
                class="
                  flex
                  items-center
                  sm:ml-auto
                  mt-5
                  sm:mt-0
                  border-t
                  sm:border-0
                  border-gray-200
                  pt-3
                  sm:pt-0
                  -mx-5
                  sm:mx-0
                  px-5
                  sm:px-0
                "
              >
                <a
                  @click="$router.push(`/otherprofile/${userchoose.user_id}`)"
                  class="dropdown-toggle w-4 h-4 text-gray-600"
                  aria-expanded="false"
                >
                  <i class="fas fa-info-circle fa-lg"></i>
                </a>
                <div class="dropdown-menu w-40">
                  <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                    <a
                      href=""
                      class="
                        flex
                        items-center
                        block
                        p-2
                        transition
                        duration-300
                        ease-in-out
                        bg-white
                        dark:bg-dark-1
                        hover:bg-gray-200
                        dark:hover:bg-dark-2
                        rounded-md
                      "
                    >
                      <i data-feather="corner-up-left" class="w-4 h-4 mr-2"></i>
                      Reply
                    </a>
                    <a
                      href=""
                      class="
                        flex
                        items-center
                        block
                        p-2
                        transition
                        duration-300
                        ease-in-out
                        bg-white
                        dark:bg-dark-1
                        hover:bg-gray-200
                        dark:hover:bg-dark-2
                        rounded-md
                      "
                    >
                      <i class="fas fa-trash"></i> <span>Delete</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div
              ref="privateMessage"
              class="overflow-y-scroll scrollbar-hidden px-5 pt-5 flex-1"
            >
              <div
                v-for="message in allmessage"
                :key="message.id"
                class="yourchat_loop"
              >
                <div
                  :class="
                    activeuser !== message.user_id
                      ? 'chat__box__text-box flex items-end float-right mb-5'
                      : 'chat__box__text-box flex items-end float-left mb-5'
                  "
                >
                  <div
                    class="
                      w-10
                      h-10
                      hidden
                      sm:block
                      flex-none
                      image-fit
                      relative
                      mr-5
                    "
                  >
                    <img
                      v-if="
                        currentuser.id == message.receiver_id &&
                        userchoose.avatar != null
                      "
                      alt="Midone Tailwind HTML Admin Template"
                      class="rounded-full"
                      :src="
                        'https://res.cloudinary.com/dtiazqxyd/image/upload/v1648964340/' +
                        userchoose.avatar
                      "
                    />
                    <img
                      v-else-if="
                        currentuser.id == message.receiver_id &&
                        userchoose.avatar == null
                      "
                      alt=""
                      class="rounded-full"
                      :src="'../dist2/images/avatardefault_92824-removebg.png'"
                    />
                  </div>
                  <div
                    :class="
                      activeuser !== message.user_id
                        ? 'bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md'
                        : 'bg-gray-200 dark:bg-dark-5 px-4 py-3 text-gray-700 dark:text-gray-300 rounded-r-md rounded-t-md'
                    "
                  >
                    {{ message.message }}
                    <div class="mt-1 text-xs text-theme-21">
                      {{ message.created_at | formatDate }}
                    </div>
                  </div>
                </div>

                <div class="clear-both"></div>
              </div>
            </div>

            <div
              class="
                pt-4
                pb-10
                sm:py-4
                flex
                items-center
                border-t border-gray-200
                dark:border-dark-5
              "
            >
              <textarea
                v-model="message"
                @keyup.enter="sendMessage"
                class="
                  chat__box__input
                  form-control
                  dark:bg-dark-3
                  h-16
                  resize-none
                  border-transparent
                  px-5
                  py-3
                  shadow-none
                  focus:ring-0
                "
                rows="1"
                placeholder="Type your message..."
              ></textarea>
              <div
                class="
                  flex
                  absolute
                  sm:static
                  left-0
                  bottom-0
                  ml-5
                  sm:ml-0
                  mb-5
                  sm:mb-0
                "
              >
                <div class="dropdown mr-3 sm:mr-5">
                  <a
                    @click="ToggleEmoji"
                    class="
                      dropdown-toggle
                      w-4
                      h-4
                      sm:w-5 sm:h-5
                      block
                      text-gray-600
                    "
                    aria-expanded="false"
                  >
                    <i class="fas fa-laugh fa-lg"></i>
                  </a>
                  
                      <div class="floating-div">
                        <picker v-if="emoStatus" @select="addEmoji" />
                      </div>
                     
                  
                </div>

                <!-- <div class="w-4 h-4 sm:w-5 sm:h-5 relative text-gray-600 mr-3 sm:mr-5">
                                            <i data-feather="paperclip" class="w-full h-full"></i> 
                                            <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0">
                                        </div> -->
              </div>
              
              <a
                @click="sendMessage"
                type="button"
                class="
                  w-8
                  h-8
                  sm:w-10 sm:h-10
                  block
                  bg-theme-1
                  text-white
                  rounded-full
                  flex-none flex
                  items-center
                  justify-center
                  mr-5
                "
                ><i class="fas fa-paper-plane"></i>
              </a>
            </div>
          </div>

          <!-- END: Chat Active -->
          <!-- BEGIN: Chat Default -->
          <div v-else class="h-full flex items-center">
            <div class="mx-auto text-center">
              <div class="">
                <img
                  style="height: 400px; width: 400px"
                  class="emptychatimg"
                  alt="Midone Tailwind HTML Admin Template"
                  v-bind:src="'dist2/images/messagingcp.png'"
                />

                <!-- <div class="font-medium">Hey, {{currentuser.name}}</div> -->
                <div class="text-gray-600 mt-1">
                  Please select a chat to start messaging.
                </div>
              </div>
            </div>
          </div>
          <!-- END: Chat Default -->
        </div>
      </div>
      <!-- END: Chat Content -->
      
    </div>
  </div>
</template>

<script>
import { Picker } from "emoji-mart-vue";

export default {
  components: {
    Picker,
  }
  ,
  data() {
    return {
      users: [],
      activeuser: null,
      allmessage: [],
      loading: false,
      message: null,
      currentuser: [],
      userchoose: {},
      profile: [],
      friendemail: "",
      emoStatus: false,
      onlineuser: [],
      notify: [],
      keywords: "",
    };
  },
  created() {
    Echo.join("bffchat")
      .here((users) => {
        this.onlineuser = users;
        // console.log(this.onlineuser);
      })
      .joining((user) => {
        this.onlineuser.push(user);
        // console.log(this.onlineuser);
      })
      .leaving((user) => {
        this.onlineuser.splice(this.onlineuser.indexOf(user), 1);
        // console.log(this.onlineuser);
      })
      .error((error) => {
        console.error(error);
      });

       Echo.private(`privatebffchat.${UserAuth.id}`)
  .listen('PrivateMessageSent', (e)=>{
    this.allmessage.push(e.message);
  });
  
    Echo.private(`bffchatnotify.${UserAuth.id}`).listen("NotifyEvent", (e) => {
      this.notify.push(e.notify);
    });
    this.getUserProfile();
    this.fetchUser();
    this.getnotify();
  },
  watch: {
    activeuser(val) {
      this.fetchmessage();
    },
    keywords(after, before) {
      this.searchuser();
    },
    allmessage(val) {
      this.scrollToEnd();
    },
  },
  methods: {
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
    searchuser() {
      axios
        .get("/search", { params: { keywords: this.keywords } })
        .then((res) => {
          // let data = Object.assign({},res.data);

          this.users = res.data;
          console.log(this.users);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    removeRequest(id,userid, index) {
      axios
        .delete(`/remove-request?noti=${id}&uid=${userid}`)
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "Friend request successfully removed!",
          });
          this.notify.splice(index, 1);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    acceptRequest(noti, index) {
      let userid = noti.user_id;
      let id = noti.id;
      const data = {
        userid: userid,
      };
      axios
        .post("/accept-request/" + id, data)
        .then((res) => {
          Toast.fire({
            icon: "success",
            title: "Friend successfully added!",
          });
          this.users.unshift(res.data[0]);
          this.notify.splice(index, 1);
          // console.log(this.users);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    invitefriend() {
      if (!this.friendemail) {
        Toast.fire({
          icon: "error",
          title: "Enter your friend email first and then submit",
        });
      } else {
        const data = {
          email: this.friendemail,
        };

        this.loading = !this.loading;

        setTimeout(() => {
          axios
            .post("/sendfriendrequest", data)
            .then((res) => {
              if (res.data.error) {
                this.loading = !this.loading;
                Toast.fire({
                  icon: "error",
                  title: "Sorry! No user found.",
                });
              } else if (res.data.exist) {
                this.loading = !this.loading;
                Toast.fire({
                  icon: "warning",
                  title: "You guys have been friends, please check again",
                });
              } else if (res.data.waiting) {
                this.loading = !this.loading;
                Toast.fire({
                  icon: "warning",
                  title: "Please wait for the user accept your friend request",
                });
              } else {
                this.loading = !this.loading;
                Toast.fire({
                  icon: "success",
                  title: "Request successfully sent!",
                });
              }
            })
            .catch((err) => {
              console.log(err);
            });
        }, 2000);
      }
    },
    ToggleEmoji() {
      this.emoStatus = !this.emoStatus;
    },
    addEmoji(e) {
      if (!e) {
        return false;
      }
      if (!this.message) {
        this.message = e.native;
      } else {
        this.message = this.message + e.native;
      }
    },
    fetchmessage() {
      axios
        .get(`/private-message/${this.activeuser}`)
        .then((res) => {
          this.allmessage = res.data.messages;
          console.log(this.allmessage);
          this.userchoose = res.data.userchat[0];
          // console.log(this.userchoose);
        })
        .catch((err) => {
          Toast.fire({
            icon: "error",
            title: "Something went wrong!",
          });
        });
    },
    fetchUser() {
      axios
        .get("/users")
        .then((res) => {
          this.users = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    scrollToEnd() {
      //   document.getElementById('private__message').scrollTo(0, 999999);
      setTimeout(() => {
        this.$refs.privateMessage.scrollTop =
          this.$refs.privateMessage.scrollHeight -
          this.$refs.privateMessage.clientHeight;
      }, 50);
    },
    getUserProfile() {
      axios
        .get("/getuserprofile")
        .then((res) => {
          this.profile = res.data.user[0];
          this.currentuser = res.data.currentUser[0];
          console.log(this.currentuser);
        })
        .catch((err) => {
          Toast.fire({
            icon: "error",
            title: "Opps! something went wrong",
          });
        });
    },
    deleteMessage(id, index) {
      axios
        .delete(`/delete-message/${id}`)
        .then((res) => {
          this.allmessage.splice(index, 1);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    fetchData() {
      axios
        .get("/messages")
        .then((res) => {
          this.allmessage = res.data;
        })
        .catch((err) => {
          Toast.fire({
            icon: "error",
            title: "Something went wrong!",
          });
        });
    },
    getnotify() {
      axios
        .get("/getallnotify")
        .then((res) => {
          this.notify = res.data;
          // console.log(this.notify);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    sendMessage() {
      if (!this.message) {
        Toast.fire({
          icon: "error",
          title: "You need to fill your message first!",
        });
      }
      const msg = {
        message: this.message,
      };
      axios
        .post("/private-message/" + this.activeuser, msg)
        .then((res) => {
          this.message = null;
          this.allmessage.push(res.data.message);
          
          setTimeout(this.scrollToMessage, 10);
          //   console.log(res.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style scoped>
.chat .chat__tabs a.active {
  background-color: #3e94da !important;
}
.bg-theme-1 {
  background-color: #1d90f4 !important;
}

.box.active {
  border-left: 6px solid #02de6b !important;
}
.box {
  border-radius: 20px;
}


.emoji-mart[data-v-7bc71df8] {
    font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", sans-serif;
    font-size: 16px;
    display: -ms-flexbox;
    box-shadow: rgba(0, 0, 0, 0.15) 0px 15px 25px, rgba(0, 0, 0, 0.05) 0px 5px 10px;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    height: 420px;
    color: #222427;
    border: 1px solid #293145;
    border-radius: 20px;
    background-color: #293145;
}

.emoji-mart-category-label{
  border-radius: 20px !important;
}
</style>