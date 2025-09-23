import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

NProgress.configure({ showSpinner: false }); // Supprimer le petit spinner

const style = document.createElement('style');
style.innerHTML = `
#nprogress .bar {
  background: #E6C200 !important; /* highlight-gold */
  height: 3px !important;
}
#nprogress .peg {
  box-shadow: 0 0 10px #E6C200, 0 0 5px #E6C200 !important;
}
`;
document.head.appendChild(style);

export default NProgress;
