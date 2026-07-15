import './bootstrap';

// Premium header: scroll state
function initStNavbar(){
  const nav = document.getElementById('stNavbar');
  if(!nav) return;
  const onScroll = ()=>{
    if(window.scrollY > 8) nav.classList.add('st-scrolled');
    else nav.classList.remove('st-scrolled');
  };
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });
}

document.addEventListener('DOMContentLoaded', initStNavbar);

