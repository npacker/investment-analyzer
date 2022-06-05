import { useState, useEffect } from 'react';
import { ActionMenu, ActionMenuItem } from '../components';

const PortfolioEditForm = props => {
  const { name, funds } = props;

  const defaultPosition = {
    symbol: funds[0].symbol,
    weight: null,
    deleted: false,
  };

  const [ positions, setPositions ] = useState([{ ...defaultPosition }]);

  const handlePositionChange = (event, index) => {
    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      return index === prevIndex
        ? { ...prevPosition, symbol: event.target.value }
        : { ...prevPosition };
    }));
  };

  const handleWeightChange = (event, index) => {
    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      return index === prevIndex
        ? { ...prevPosition, weight: event.target.value }
        : { ...prevPosition };
    }));
  };

  const handleDelete = (event, index) => {
    setPositions(prevPositions => prevPositions.map((prevPosition, prevIndex) => {
      return index === prevIndex
        ? { ...prevPosition, deleted: true }
        : { ...prevPosition };
    }));
  };

  const handleAdd = event => {
    setPositions(prevPositions => prevPositions.concat([{ ...defaultPosition }]));
  };

  const handleNormalizeWeights = event => {
  };

  const handleDragStart = event => {
  };

  const handleDragEnd = event => {
  };

  const handleDragEnter = event => {
  };

  const handleDragOver = event => {
  };

  const handleDrop = event => {
  };

  return (
    <form className="portfolio-form" method="POST">
      <label htmlFor="name">Name</label>
      <input type="text" name="name" defaultValue={name} size="40" required />
      <div className="portfolio-row portfolio-headers">
        <div className="portfolio-header">
          Position
        </div>
        <div className="portfolio-header">
          Weight
        </div>
      </div>
      {positions.map((position, index) => {
        if (position.deleted === false) {
          return (
            <div key={index} className="portfolio-row portfolio-position-row">
              <button type="button" className="drag-handle">
                <i className="material-icons">drag_indicator</i>
              </button>
              <div className="portfolio-position">
                <label htmlFor={`position[${index}][symbol]`} className="visually-hidden">
                  Position 1
                </label>
                <select
                  name={`position[${index}][symbol]`}
                  onChange={event => handlePositionChange(event, index)}
                  defaultValue={position.symbol}
                >
                  {funds.map(fund =>
                    <option key={fund.symbol} value={fund.symbol}>{fund.name}</option>
                  )}
                </select>
              </div>
              <div className="portfolio-weight">
                <label htmlFor={`position[${index}][weight]`} className="visually-hidden">
                  Allocation for Position {index}
                </label>
                <input
                  type="number"
                  name={`position[${index}][weight]`}
                  size="3"
                  min="0"
                  max="100"
                  step="0.01"
                  onChange={event => handleWeightChange(event, index)}
                  defaultValue={position.weight}
                />
                <span className="input-decorator percent-decorator">%</span>
              </div>
              <button
                type="button"
                className="position-delete"
                onClick={event => handleDelete(event, index)}
              >
                <i className="material-icons">delete</i>
              </button>
            </div>
          );
        }
      })}
      <div className="portfolio-row portfolio-totals">
        <button type="button" className="drag-handle" disabled>
          <i className="material-icons">drag_indicator</i>
        </button>
        <div className="portfolio-position"></div>
        <div className="portfolio-weight">
          <label className="visually-hidden" htmlFor="total_weight">
            Total
          </label>
          <input
            type="number"
            name="total_weight"
            value={positions.reduce((total, position) => {
              return position.deleted
                ? total
                : total + parseFloat(position.weight || 0.0);
            }, 0.0)}
            readOnly
          />
          <span className="input-decorator percent-decorator">%</span>
        </div>
        <button type="button" className="position-delete" disabled>
          <i className="material-icons">delete</i>
        </button>
      </div>
      <div className="form-actions">
        <input type="submit" value="Submit" />
        <div className="portfolio-actions">
          <ActionMenu>
            <ActionMenuItem onClick={handleAdd}>Add Position</ActionMenuItem>
            <ActionMenuItem onClick={handleNormalizeWeights}>Normalize Weights</ActionMenuItem>
          </ActionMenu>
        </div>
      </div>
    </form>
  );
};

export default PortfolioEditForm;
