export default function navigation(){
  const menuButton=document.querySelector('.menu-toggle');
  const mobileNav=document.querySelector('#mobile-nav');
  if(!menuButton||!mobileNav)return;
  if(window.gsap) return;
  menuButton.addEventListener('click',()=>{
    const open=menuButton.getAttribute('aria-expanded')==='true';
    menuButton.setAttribute('aria-expanded',String(!open));
    mobileNav.hidden=open;
  });
  mobileNav.querySelectorAll('a').forEach(link=>link.addEventListener('click',()=>{
    mobileNav.hidden=true;
    menuButton.setAttribute('aria-expanded','false');
  }));
}
