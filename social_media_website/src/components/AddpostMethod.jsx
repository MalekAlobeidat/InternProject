import { data } from 'jquery';
import React, { useState, useEffect } from 'react';

function AddpostMethod() {
  const [userId, setUserId] = useState('');
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
    const storedUserId = sessionStorage.getItem('userId');
  
    try {
      const response = await fetch(`http://127.0.0.1:8000/api/getUserPosts/${storedUserId}`);
      if (response.ok) {
        const fetchedPosts = await response.json();
        setPosts(fetchedPosts);
        console.log(fetchedPosts); // Corrected the variable name here
      } else {
        console.error('Failed to fetch user posts');
      }
    } catch (error) {
      console.error('Error occurred while fetching user posts:', error);
    }
  };
  
  useEffect(() => {
    fetchUserPosts();
  }, []);
  

  return (
    <div>
      <form onSubmit={handleSubmit}>
        <div>
          <label htmlFor="user-id" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            User ID
          </label>
          <input
            type="text"
            id="user-id"
            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder=""
            value={userId}
            onChange={(e) => setUserId(e.target.value)}
          />
          <label htmlFor="privacy-id" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Privacy ID
          </label>
          <input
            type="text"
            id="privacy-id"
            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder=""
            value={privacyId}
            onChange={(e) => setPrivacyId(e.target.value)}
          />
          <label htmlFor="content" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Content
          </label>
          <input
            type="text"
            id="content"
            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder=""
            value={content}
            onChange={(e) => setContent(e.target.value)}
          />
          <label htmlFor="file_input" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Media
          </label>
          <input
            type="file"
            id="file_input"
            className="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
            onChange={handleFileChange}
          />
        </div>
        <button type="submit" className="bg-blue-500 text-white p-2 rounded-lg mt-4">
          Submit
        </button>
      </form>
      <div className='malek'>
        <ul>
            {/* <h2>Posts for User ID: {userId}</h2> */}
          {posts.map((post) => (
              <div key={post.PostID}>{post.PostID}
              <div>              <h1>{post.Content}</h1>
</div>
              <img src={`/${post.Media}`}/>
              </div>
              
              
          ))}
        </ul>









      </div>
    </div>
  );
}

export default AddpostMethod;
