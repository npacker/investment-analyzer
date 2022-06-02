import '../../styles/modules/ActionsMenu.css';

import { useState } from 'react';

const ActionsMenu = props => {
  const { children } = props;
  const [ hidden, setHidden ] = useState(true);

  const toggleMenu = event => {
    setHidden(!hidden);
  }

  return (
    <div className="actions-menu">
      <button type="button" className="actions-button" onClick={toggleMenu}>
        <i className="material-icons">settings</i>
      </button>
      <ul className={`actions-menu-dropdown ${hidden ? 'dropdown-hidden' : null}`}>
        { React.Children.map(children, child => <li className="actions-menu-item">{ child }</li>) }
      </ul>
    </div>
  )
}

export default ActionsMenu
