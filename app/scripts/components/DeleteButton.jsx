const DeleteButton = props => {
  return (
    <button {...props} type="button" className="position-delete">
      <i className="material-icons">
        delete
      </i>
    </button>
  );
};

export default DeleteButton;
