// import React, { useState, useEffect } from 'react';
// import '../styles/login.css'
// import mohannad from '../../images/mohannad.jpg'
// import { CiVideoOn } from "react-icons/ci";
// import { IoImageOutline } from "react-icons/io5";
// import { IoHappyOutline } from "react-icons/io5";
// import balck from '../../images/black.jpg'
// import { AiOutlineLike } from "react-icons/ai";
// import { FaRegCommentAlt } from "react-icons/fa";
// import { GoShareAndroid } from "react-icons/go";
// import { IoMdClose } from "react-icons/io";
// import { HiDotsHorizontal } from "react-icons/hi";
// import { input } from '@material-tailwind/react';
// function ShowAllPosts() {
//   const [comments, setComments] = useState([]);
//   const [showallpost , setshowallpost]=useState([]);


//   const [likeCount, setLikeCount] = useState(0); // Initialize with 0
//   const [isLiked, setIsLiked] = useState(false);
  



 



 
//   // Handle like click for a post
//   const handleLikeClick = async (postId) => {
//     try {
//       const UserID = sessionStorage.getItem('userid');

//       const response = await fetch('http://127.0.0.1:8000/api/like', {
//         method: 'POST',
//         headers: {
//           'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({
//           UserID: UserID,
//           PostID: postId,
//         }),
//       });

//       if (response.ok) {
//         setIsLiked(true);
//         setLikeCount((prevCount) => prevCount + 1);
//       } else {
//         console.error('Failed to like the post');
//       }
//     } catch (error) {
//       console.error('Error occurred while liking the post:', error);
//     }
//   };

//   // Fetch comments for a post
//   const fetchComments = async (postId) => {
//     try {
//       const response = await fetch(`http://127.0.0.1:8000/api/comments/${postId}`);
//       if (response.ok) {
//         const data = await response.json();
//         setComments(data);
//         console.log(data);
//       } else {
//         console.error('Failed to fetch comments:', response.statusText);
//       }
//     } catch (error) {
//       console.error('Error fetching comments:', error);
//     }
//   };
//   const addComment = async (postId, commentText) => {
//     try {
//       const userId = sessionStorage.getItem('userid');
  
//       const response = await fetch('http://127.0.0.1:8000/api/comments', {
//         method: 'POST',
//         headers: {
//           'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({
//           UserID: userId,
//           PostID: postId,
//           commentText: commentText,
//         }),
//       });
  
//       if (response.ok) {
//         // Comment added successfully
//         console.log('Comment added successfully');
//         // Fetch comments again to update the list
//         fetchComments(postId);
//       } else {
//         // Handle error, e.g., show an error message
//         console.error('Failed to add comment');
//       }
//     } catch (error) {
//       console.error('Error occurred while adding comment:', error);
//     }
//   };
//   // Empty
  
//   // Use the addComment function where you want to add a comment
//   // For example, you can call it when a user submits a comment form
  
//   // Inside your component, where you handle comment submission
//   const handleCommentSubmit = (postId, commentText) => {
//     // Call the addComment function with the post ID and comment text
//     addComment(postId, commentText);
//   };
  
 

  
  
//   useEffect(() => {
//     const fetchPosts = async () => {
//       try {
//         const response = await fetch('http://127.0.0.1:8000/api/posts');
//         if (response.ok) {
//           const show = await response.json();
//           setshowallpost(show);
//           console.log(show);
//         } else {
//           console.error('Failed to fetch posts');
//         }
//       } catch (error) {
//         console.error('Error occurred:', error);
//       }
//     };

//     fetchPosts();
//   }, []);

//   return (
//     <>
//     {showallpost.map((post) => (
//       <div
//         className='postsection'
//         key={post.PostID}
//         style={{
//           height: post.Media ? 'auto' : '20vh',
//           border:
//             post.PrivacyID === '1' ? '2px solid red' : post.PrivacyID === '2' ? '2px solid green' : 'none',
//         }}
//       >
//         <div className='imageandnameandicont'>
//           <div className='msh3arf'>
//             <div className='idk'>
//               <img className='w-10 h-10 rounded-full' src={post.ProfilePicture} alt='Rounded avatar' />
//               <h3>{post.userName}</h3>
//               <h3>{post.PrivacyID}</h3>
//             </div>
//             <div
//               className='closedots'
//               style={{ display: sessionStorage.getItem('userid') == post.UserID ? 'block' : 'none' }}
//             >
//               <div>
//                 <HiDotsHorizontal
//                   style={{ cursor: 'pointer' }}
                  
//                 />
//               </div>
//               <div style={{ display: sessionStorage.getItem('userid') == post.UserID ? 'block' : 'none' }}>
//                 <IoMdClose
              
//                 />
//               </div>
//             </div>
//           </div>
//           <hr />
//         </div>
//         <div className='zhgt' style={{ overflow: 'auto', height: 'auto' }}>
//           {post.Content}
//         </div>
//         <div className='forimgae' style={{ display: post.Media ? 'block' : 'none' }}>
//           {post.Media && <img src={post.Media} alt='Post Media' />}
//         </div>
//         <div className='likeandstuff'>
//           <div
//             className='likelike'
//             onClick={() => handleLikeClick(post.PostID)}
//             style={{ cursor: 'pointer' }}
//           >
//             <AiOutlineLike />
//             {isLiked ? 'Liked' : 'Like'} {likeCount > 0 && `(1)`}
//           </div>
//           <div className='likelike'>
//             <FaRegCommentAlt />
//             <div className='comments-section'>
//               {post.comments.length > 0 ? (
//                 <div className='comments-section'>
//                   {post.comments.map((comment) => (
//                     <div key={comment.CommentID} className='comment' style={{ display: 'flex', flexDirection: 'column' }}>
//                       <strong>{comment.userName}</strong>: {comment.commentText}
//                     </div>
//                   ))}
//                 </div>
//               ) : (
//                 <p>No comments available.</p>
//               )}
//             </div>
//             <button onClick={() => fetchComments(post.PostID)}>Fetch Comments</button>
//           </div>
//           <div className='likelike'>
//             <GoShareAndroid />
//             Report
//           </div>
//         </div>
//         <form
//           onSubmit={(e) => {
//             e.preventDefault();
//             const commentText = e.target.elements.commentText.value;
//             handleCommentSubmit(post.PostID, commentText);
//           }}
//         >
//           <input type='text' name='commentText' placeholder='Type your comment' />
//           <button type='submit'>Add Comment</button>
//         </form>
//       </div>
//     ))}
//   </>
//   );
// }

// export default ShowAllPosts;
