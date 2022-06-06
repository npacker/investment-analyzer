const PositionWeightInput = props => (
  <>
    <input {...props} type="number" size="3" min="0" max="100" step="0.01" />
    <span className="input-decorator percent-decorator">
      %
    </span>
  </>
);

export default PositionWeightInput;
