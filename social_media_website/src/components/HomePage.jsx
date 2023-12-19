import React, { useState, useEffect } from 'react';
import '../styles/login.css'
import mohannad from '../../images/mohannad.jpg'
import { CiVideoOn } from "react-icons/ci";
import { IoImageOutline } from "react-icons/io5";
import { IoHappyOutline } from "react-icons/io5";
import balck from '../../images/black.jpg'
import { AiOutlineLike } from "react-icons/ai";
import { FaRegCommentAlt } from "react-icons/fa";
import { GoShareAndroid } from "react-icons/go";
import { IoMdClose } from "react-icons/io";
import { HiDotsHorizontal } from "react-icons/hi";
import { input } from '@material-tailwind/react';
function HomePage() {
  const [userid, setUserId] = useState('');
  const [privacyId, setPrivacyId] = useState('');
  const [content, setContent] = useState('');
  const [media, setMedia] = useState(null);
  const [posts, setPosts] = useState([]);

  const handleFileChange = (e) => {
    // Assuming you only want to upload a single file
    setMedia(e.target.files[0]);
  };
  const handleSubmit = async (e) => {
    e.preventDefault();
    const privacyId = 1;
    const userId  = sessionStorage.getItem('userid')
       const formData = new FormData();
    formData.append('UserID', userId);
    formData.append('PrivacyID', privacyId);
    formData.append('Content', content);
    formData.append('Media', media);

    try {
      const response = await fetch('http://127.0.0.1:8000/api/posts', {
        method: 'POST',
        body: formData,
      });

      if (response.ok) {
        // Handle success, e.g., show a success message
        console.log('Post created successfully');
        const responseData = await response.json();
        sessionStorage.setItem('userId', responseData.userId);
        console.log(responseData.userId);
        fetchUserPosts();
      } else {
        // Handle error, e.g., show an error message
        console.error('Failed to create post');
      }
    } catch (error) {
      console.error('Error occurred:', error);
    }
  };

  const fetchUserPosts = async () => {
    console.log(userid);
    const userId = sessionStorage.getItem('userid')
  
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/friendsPosts/${userId}`);
      if (response.ok) {
        const fetchedPosts = await response.json();
        setPosts(fetchedPosts.posts); // Set only the posts array
        console.log(fetchedPosts); // Corrected the variable name here
      } else {
        console.error('Failed to fetch user posts');
      }
    } catch (error) {
      console.error('Error occurred while fetching user posts:', error);
    }
  }
  ;const deletePost = async (postId) => {
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/posts/${postId}`, {
        method: 'DELETE',
      });

      if (response.ok) {
        // Handle success, e.g., show a success message
        alert('Post deleted successfully');
        fetchUserPosts();
      } else {
        // Handle error, e.g., show an error message
        console.error('Failed to delete post');
      }
    } catch (error) {
      console.error('Error occurred while deleting post:', error);
    }
  };



  const updatePost = async (postId, updatedContent, updatedMedia) => {
    console.log(updatedMedia);
    const userId = sessionStorage.getItem('userid');
    const formData = new FormData();
  
    // Append form data
    formData.append('UserID', userId);
    formData.append('Content', updatedContent);
    formData.append('PrivacyID', 1);

    // Check if updatedMedia is provided before appending it
    if (updatedMedia) {
      formData.append('Media', updatedMedia);
    }
  
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/posts/${postId}`, {
        method: 'POST',
        body: formData,
      });

      if (response.ok) {
        // Handle success, e.g., show a success message
        alert('Post updated successfully');
        const data = await response.json();
        console.log(data);        
        // fetchUserPosts();
      } else {
        // Handle error, e.g., show an error message
        console.error('Failed to update post');
      }
    } catch (error) {
      console.error('Error occurred while updating post:', error);
    }
  };
  
  const [isLiked, setIsLiked] = useState(false);

  const handleLikeClick = async (postId) => {
    try {
      // Assuming post.UserID and post.PostID are available in your component state
      const userId = sessionStorage.getItem('userid');

      const response = await fetch('http://127.0.0.1:8000/api/like', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          UserID: userId,
          PostID: postId,
        }),
      });

      if (response.ok) {
        // Update UI to reflect that the post is liked
        setIsLiked(true);
      } else {
        console.error('Failed to like the post');
      }
    } catch (error) {
      console.error('Error occurred while liking the post:', error);
    }
  };


  
  useEffect(() => {
    fetchUserPosts();
  }, []);

  
  return (
    <>

    <div className='HomePage'>
      <div className='NavBar'>
        

<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
  </a>
  <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
      <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Get started</button>
      <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
  </div>
  <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
    <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
      <li>
        <a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500" aria-current="page">Home</a>
      </li>
      <li>
        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
      </li>
      <li>
        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
      </li>
      <li>
        <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
      </li>
    </ul>
  </div>
  </div>
</nav>

      </div>
      <div className='SideBar'>
     

<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar" style={{marginTop:"69px"}} >
   <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800" id='sidbar'>
      <ul class="space-y-2 font-medium">
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
               </svg>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                  <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Kanban</span>
               <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Inbox</span>
               <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                  <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                  <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Products</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Sign In</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                  <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                  <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Sign Up</span>
            </a>
         </li>
      </ul>
   </div>
</aside>

      </div>
        <div className='middlscontnct'>
          {/* <div className='StorySection'>
            <div className='Story'> 
            <img src={mohannad}/>
             <p>Mohannad Ayman</p></div>
                <div className='Story'>
                <img src={mohannad}/>
                <p>Mohannad Ayman</p>
                </div>
                <div className='Story'>
                <img src={mohannad}/>
                <p>Mohannad Ayman</p>
                </div>
                <div className='Story'>
                <img src={mohannad}/>
                    <p>Mohannad Ayman</p>
                </div>
                </div> */}
                <div className='addpostsection'>
                  <div className='imageandinput'>
                  <img class="w-10 h-10 rounded-full" src={sessionStorage.getItem('ProfilePicture')} alt="Rounded avatar" />
                    <input placeholder='Whats is in your mind'     
                    onChange={(e) => setContent(e.target.value)}
                   value={content}
/>
                  </div>
                  <hr/>
                  <div className='three'>

                    <div className='iconname'>
  <IoImageOutline style={{color:'green'}} />
  <input type="file" style={{opacity: 0, position: 'absolute'}} onChange={handleFileChange}
 />
  Image/Video
</div>

                    <div className='iconname'>
                      <button type='submit' onClick={handleSubmit}>
                      ADD POST

                      </button>

                    </div>
                  
                  </div>
                </div>
                {posts.map((post) => {
    console.log(post); // You can log post details here if needed

    return (
        <div className='postsection' key={post.PostID} style={{ height: post.Media ? 'auto' : '20vh' }}>
            <div className='imageandnameandicont'>
                <div className='msh3arf'>
                    <div className='idk'>
                        <img className="w-10 h-10 rounded-full" src={post.ProfilePicture} alt="Rounded avatar" />
                        {/* <h3>User ID : {post.UserID}</h3> */}
                        <h3>{post.userName}</h3>
                    </div>
                    <div className='closedots' style={{ display: sessionStorage.getItem('userid') == post.UserID ? 'block' : 'none' }}>
                        <div>
                        <HiDotsHorizontal
 style={{ cursor: 'pointer' }}
 onClick={() => {
   // Prompt for updated content
   const updatedContent = prompt('Enter updated content:', post.Content);
 
   // Check if the user cancelled or entered empty content
   if (updatedContent === null || updatedContent.trim() === '') {
     return; // Do nothing if cancelled or empty content
   }
 
   // Create a file input element
   const fileInput = document.createElement('input');
   fileInput.type = 'file';
   fileInput.accept = 'image/*'; // Adjust this based on the accepted file types
 
   // Event listener for file input change
   fileInput.addEventListener('change', (event) => {
     // Check if a file was selected
     if (event.target.files.length > 0) {
       const file = event.target.files[0];
       // Assuming updatePost expects postId, updatedContent, and file as parameters
       updatePost(post.PostID, updatedContent, file);
     } else {
       // Handle the case where the user didn't select a file
       alert('Please select an image file.');
     }
   });
 
   // Trigger the file input click to prompt the user to select a file
   fileInput.click();
 }}
/>

           </div>
                        <div style={{ display: sessionStorage.getItem('userid') == post.UserID ? 'block' : 'none' }}>
                            <IoMdClose style={{ cursor: 'pointer' }}   onClick={() => deletePost(post.PostID)}/>
                        </div>
                    </div>
                </div>
                <hr/>
                <div className='zhgt' style={{ overflow: 'scroll' }}>
                    {post.Content}
                </div>
            </div>
            <div className='forimgae' style={{ display: post.Media ? 'block' : 'none' }}>
              {post.Media && <img src={post.Media} alt="Post Media" />}
            </div>  
            <div className='likeandstuff'>
            <div
              className='likelike'
              onClick={() => handleLikeClick(post.PostID)}  // Pass post.PostID to the handler
              style={{ cursor: 'pointer' }}
            >
              <AiOutlineLike />
              {isLiked ? 'Liked' : 'Like'}
            </div>
                <div className='likelike'>
                    <FaRegCommentAlt/>
                    Comment
                </div>
                <div className='likelike'>
                    <GoShareAndroid/>
                    Report
                </div>
            </div>
        </div>
    );
})}
          
          
        </div>

    </div>
    </>
  )
}

export default HomePage