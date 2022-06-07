import * as ReactDOMClient from 'react-dom/client';
import { PortfolioEditForm } from './components';

const portfolioFormContainer = document.getElementById('portfolio-form-react-container');
const portfolioFormRoot = ReactDOMClient.createRoot(portfolioFormContainer);

portfolioFormRoot.render(
  <PortfolioEditForm name={window.data.portfolio_name} funds={window.data.portfolio_funds} />
);
